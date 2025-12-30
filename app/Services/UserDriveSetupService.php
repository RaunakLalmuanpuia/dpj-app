<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserGoogleDrive;
use App\Services\Google\GoogleClientFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

            // Validate existing folder
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

        // 1. User creates the container folder (User Owns Folder)
        $folderId = $userDrive->createFolder("DPJ (" . ucfirst($plan) . ") - {$user->name}");

        // 2. Get Service Account Email to grant write access
        $serviceAccountEmail = $this->factory->getServiceAccountEmail();

        // 3. User grants 'Writer' access to Service Account so it can drop files here
        $userDrive->share($folderId, $serviceAccountEmail, 'writer');

        $createdIds = [];
        foreach ($templates as $index => $templateId) {
            // 4. Admin performs the copy (Preserves Scripts)
            // Note: This consumes SERVICE ACCOUNT Quota, not User Quota
            try {
                $createdIds[] = $adminDrive->copyFile($templateId, "Sheet " . ($index + 1), $folderId);
            } catch (\Exception $e) {
                // Catch quota errors specifically to give clearer logs
                Log::error("Drive Copy Failed: " . $e->getMessage());
                throw $e;
            }
        }

        // 5. Cleanup: Revoke Service Account access (Optional, keeping it can help with debugging)
        try {
            $userDrive->revokeAccess($folderId, $serviceAccountEmail);
        } catch (\Exception $e) {
            Log::warning("Failed to revoke SA access: " . $e->getMessage());
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
