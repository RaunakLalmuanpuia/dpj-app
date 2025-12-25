<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserGoogleDrive;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    /* -----------------------------
     | GOOGLE LOGIN
     |-----------------------------*/
    public function redirectToGoogle(Request $request)
    {
        // Store the plan in the 'state' parameter
        $state = bin2hex(random_bytes(16)) . '-' . $request->query('plan', 'essential');
//        dd($state);
        return Socialite::driver('google')
            ->scopes([
                'openid',
                'profile',
                'email',
                'https://www.googleapis.com/auth/drive',
            ])
            ->with([
                'access_type' => 'offline',
                'prompt' => 'consent',
                'state' => $state,
            ])
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Extract plan from state (e.g., "randomhash-habit" -> "habit")
        $state = $request->input('state');
        $plan = str_contains($state, '-') ? explode('-', $state)[1] : 'essential';


        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'password' => bcrypt(rand(100000, 999999)),
                'google_access_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]
        );

        Auth::login($user);

        // Check if this specific user already has THIS specific plan synced
        $existingPlan = UserGoogleDrive::where('user_id', $user->id)
            ->where('plan_type', $plan)
            ->first();

        if (!$existingPlan) {
            $folderId = $this->setupUserDrive($user, $plan);
        }
        else {
            // 3. Use the existing ID if it does
            $folderId = $existingPlan->folder_id;
        }
        // Generate the URL using the $folderId from either branch
        $driveUrl = "https://drive.google.com/drive/folders/{$folderId}";

        return redirect()->route('home')->with('drive_url', $driveUrl);
    }

    /* -----------------------------
     | MAIN SETUP FLOW
     |-----------------------------*/
    protected function setupUserDrive(User $user, string $plan)
    {
        $adminDrive = $this->adminDrive();
        $userDrive  = $this->userDrive($user);

        // Define different templates based on the plan
        $planTemplates = [
            'essential' => [env('GOOGLE_TEMPLATE_SHEET_1'), env('GOOGLE_TEMPLATE_SHEET_2')],
            'habit'     => [env('GOOGLE_TEMPLATE_SHEET_1'), env('GOOGLE_TEMPLATE_SHEET_3'), env('GOOGLE_TEMPLATE_SHEET_4')],
            'focus'     => [env('GOOGLE_TEMPLATE_SHEET_1'), env('GOOGLE_TEMPLATE_SHEET_5')],
            'legacy'    => [env('GOOGLE_TEMPLATE_SHEET_1'), env('GOOGLE_TEMPLATE_SHEET_2'), env('GOOGLE_TEMPLATE_SHEET_3'), env('GOOGLE_TEMPLATE_SHEET_4')],
        ];

        $templates = $planTemplates[$plan] ?? $planTemplates['essential'];

        // 1. Create Folder
        $folder = $userDrive->files->create(new Google_Service_Drive_DriveFile([
            'name' => 'DPJ (' . ucfirst($plan) . ') - ' . $user->name,
            'mimeType' => 'application/vnd.google-apps.folder',
        ]), ['fields' => 'id']);

        // 2. Process Templates
        $createdIds = [];
        foreach ($templates as $index => $templateId) {
            $this->adminShareTemplate($adminDrive, $templateId, $user->email);

            $newFileId = $this->userCopyTemplate(
                $userDrive,
                $templateId,
                "Sheet " . ($index + 1),
                $folder->id
            );

            $createdIds[] = $newFileId;

            $this->adminRevokeTemplate($adminDrive, $templateId, $user->email);
        }

        UserGoogleDrive::create([
            'user_id' => $user->id,
            'folder_id' => $folder->id,
            'plan_type' => $plan, // Store which plan they chose
            'sheet_ids' => json_encode($createdIds),
        ]);

        return $folder->id;
    }

    /* -----------------------------
     | ADMIN DRIVE (SERVICE ACCOUNT)
     |-----------------------------*/
    protected function adminDrive(): Google_Service_Drive
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/private/google/admin-service-account.json'));
        $client->addScope(Google_Service_Drive::DRIVE);

        return new Google_Service_Drive($client);
    }

    protected function adminShareTemplate(Google_Service_Drive $drive, string $templateId, string $email)
    {
        $permission = new Google_Service_Drive_Permission([
            'type' => 'user',
            'role' => 'reader',
            'emailAddress' => $email,
        ]);

        $drive->permissions->create(
            $templateId,
            $permission,
            ['sendNotificationEmail' => false]
        );
    }

    protected function adminRevokeTemplate(Google_Service_Drive $drive, string $templateId, string $email)
    {
        $permissions = $drive->permissions->listPermissions($templateId);

        foreach ($permissions as $permission) {
            if ($permission->emailAddress === $email) {
                $drive->permissions->delete($templateId, $permission->id);
            }
        }
    }

    /* -----------------------------
     | USER DRIVE (SOCIALITE TOKEN)
     |-----------------------------*/
    protected function userDrive(User $user): Google_Service_Drive
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));

        $client->setAccessToken([
            'access_token' => $user->google_access_token,
            'refresh_token' => $user->google_refresh_token,
        ]);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
        }

        return new Google_Service_Drive($client);
    }

    protected function userCopyTemplate(Google_Service_Drive $drive, string $templateId, string $name, string $folderId) {
        $file = $drive->files->copy(
            $templateId,
            new Google_Service_Drive_DriveFile(['name' => $name])
        );

        $drive->files->update(
            $file->id,
            new Google_Service_Drive_DriveFile(),
            [
                'addParents' => $folderId,
                'removeParents' => 'root',
            ]
        );

        return $file->id;
    }
}
