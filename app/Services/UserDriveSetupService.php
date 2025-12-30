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

        // 1. User creates the main folder
        $folderId = $userDrive->createFolder("DPJ (" . ucfirst($plan) . ") - {$user->name}");

        $createdIds = [];

        // The MIME type for Excel (used as the transport format)
        $excelMime = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

        foreach ($templates as $index => $templateId) {
            // 2. Admin EXPORTS the template to RAM (as Excel)
            // This reads the file content without needing permission to 'copy' it directly
            $fileContent = $adminDrive->exportFile($templateId, $excelMime);

            // 3. User UPLOADS the content as a new Sheet
            // Since the User is uploading, the User OWNS the file and uses THEIR quota.
            $createdIds[] = $userDrive->createFile(
                "Sheet " . ($index + 1), // Name
                $folderId,                // Parent
                $fileContent,             // Data
                $excelMime                // Source Type
            );
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
