<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserGoogleDrive;
use App\Services\Google\GoogleClientFactory;
use Illuminate\Support\Facades\DB;

class UserDriveSetupService
{
    protected $factory;

    public function __construct(GoogleClientFactory $factory)
    {
        $this->factory = $factory;
    }

    public function getOrCreateUserFolder(User $user, string $plan): string
    {
        return DB::transaction(function () use ($user, $plan) {
            $existing = UserGoogleDrive::where('user_id', $user->id)->where('plan_type', $plan)->first();
            $userDrive = $this->factory->createUserDriveService($user);

            if ($existing && $userDrive->isFolderValid($existing->folder_id)) {
                return $existing->folder_id;
            }

            if ($existing) $existing->delete();

            return $this->setupNewDrive($user, $plan, $userDrive);
        });
    }

    private function setupNewDrive(User $user, string $plan, $userDrive): string
    {
        $adminDrive = $this->factory->createAdminDriveService();
        $templates = $this->getTemplatesForPlan($plan);

        // 1. User creates the folder (User is Owner)
        $folderId = $userDrive->createFolder("DPJ (" . ucfirst($plan) . ") - {$user->name}");

        // 2. Get Service Account Email
        $serviceAccountEmail = $this->factory->getServiceAccountEmail();

        // 3. User shares the NEW FOLDER with Service Account (as Writer)
        // This allows the Service Account to put files into this folder.
        $userDrive->share($folderId, $serviceAccountEmail, 'writer');

        $createdIds = [];
        foreach ($templates as $index => $templateId) {
            // 4. Admin (Service Account) performs the copy.
            // Admin owns the template, and now has write access to the destination folder.
            $createdIds[] = $adminDrive->copyFile($templateId, "Sheet " . ($index + 1), $folderId);
        }

        // 5. Cleanup: User revokes Service Account access to the folder
        try {
            $userDrive->revokeAccess($folderId, $serviceAccountEmail);
        } catch (\Exception $e) {
            // Log this silently; it's not critical if revocation fails,
            // but prevents the main flow from breaking.
            \Illuminate\Support\Facades\Log::warning("Failed to revoke SA access: " . $e->getMessage());
        }

        UserGoogleDrive::updateOrCreate(
            ['user_id' => $user->id, 'plan_type' => $plan],
            ['folder_id' => $folderId, 'sheet_ids' => json_encode($createdIds)]
        );

        return $folderId;
    }

    private function getTemplatesForPlan(string $plan): array
    {
        $map = [
            'free' => [env('GOOGLE_TEMPLATE_SHEET_1'), env('GOOGLE_TEMPLATE_SHEET_2')],
            'pro'     => [env('GOOGLE_TEMPLATE_SHEET_1'), env('GOOGLE_TEMPLATE_SHEET_2'), env('GOOGLE_TEMPLATE_SHEET_3')],
            'enterprise'     => [env('GOOGLE_TEMPLATE_SHEET_1'), env('GOOGLE_TEMPLATE_SHEET_5')],
        ];
        return $map[$plan] ?? $map['free'];
    }
}
