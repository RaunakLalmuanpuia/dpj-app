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

        // 1. User creates the container folder
        $folderId = $userDrive->createFolder("DPJ (" . ucfirst($plan) . ") - {$user->name}");

        $createdIds = [];

        foreach ($templates as $index => $templateId) {
            // STRATEGY: Share -> Copy (as User) -> Revoke
            // This ensures the USER owns the file and uses USER storage.

            try {
                // A. Admin grants User read access to the template
                // (Required so User can see it to copy it)
                $adminDrive->share($templateId, $user->email, 'reader');

                // B. User performs the copy
                // Since $userDrive runs this, the User becomes the OWNER.
                $createdIds[] = $userDrive->copyFile($templateId, "Sheet " . ($index + 1), $folderId);

            } catch (\Exception $e) {
                Log::error("Drive Share/Copy Failed: " . $e->getMessage());
                throw $e;
            } finally {
                // C. Always revoke access, even if copy failed, to keep templates secure
                try {
                    $adminDrive->revokeAccess($templateId, $user->email);
                } catch (\Exception $e) {
                    Log::warning("Failed to revoke template access: " . $e->getMessage());
                }
            }
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
