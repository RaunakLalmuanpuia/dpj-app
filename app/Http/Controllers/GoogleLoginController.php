<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserGoogleDrive;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    /* -----------------------------
     | GOOGLE LOGIN
     |-----------------------------*/
    public function redirectToGoogle()
    {
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
            ])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

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

        if (!$user->googleDrive) {
            $this->setupUserDrive($user);
        }

        return redirect()->route('home');
    }

    /* -----------------------------
     | MAIN SETUP FLOW
     |-----------------------------*/
    protected function setupUserDrive(User $user)
    {
        $adminDrive = $this->adminDrive();
        $userDrive  = $this->userDrive($user);

        // 1️⃣ Create user folder
        $folder = $userDrive->files->create(
            new Google_Service_Drive_DriveFile([
                'name' => 'DPJ - ' . $user->name,
                'mimeType' => 'application/vnd.google-apps.folder',
            ]),
            ['fields' => 'id']
        );

        $templates = [
            env('GOOGLE_TEMPLATE_SHEET_1'),
            env('GOOGLE_TEMPLATE_SHEET_2'),
            env('GOOGLE_TEMPLATE_SHEET_3'),
        ];

        // 2️⃣ ADMIN → Share templates
        foreach ($templates as $templateId) {
            $this->adminShareTemplate($adminDrive, $templateId, $user->email);
        }

        // 3️⃣ USER → Copy templates
        $sheet1 = $this->userCopyTemplate($userDrive, $templates[0], 'Sheet One', $folder->id);
        $sheet2 = $this->userCopyTemplate($userDrive, $templates[1], 'Sheet Two', $folder->id);
        $sheet3 = $this->userCopyTemplate($userDrive, $templates[2], 'Sheet Three', $folder->id);

        // 4️⃣ Save DB
        UserGoogleDrive::create([
            'user_id' => $user->id,
            'folder_id' => $folder->id,
            'sheet_1_id' => $sheet1,
            'sheet_2_id' => $sheet2,
            'sheet_3_id' => $sheet3,
        ]);

        // 5️⃣ ADMIN → Revoke access
        foreach ($templates as $templateId) {
            $this->adminRevokeTemplate($adminDrive, $templateId, $user->email);
        }
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

    protected function userCopyTemplate(
        Google_Service_Drive $drive,
        string $templateId,
        string $name,
        string $folderId
    ) {
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
