<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserGoogleDrive;
use App\Services\Google\GoogleClientFactory;

class UserDriveSetupService
{
    protected $factory;

    public function __construct(GoogleClientFactory $factory)
    {
        $this->factory = $factory;
    }

    public function getOrCreateUserFolder(User $user, string $plan): string
    {
        $existing = UserGoogleDrive::where('user_id', $user->id)->where('plan_type', $plan)->first();
        $userDrive = $this->factory->createUserDriveService($user);

        if ($existing && $userDrive->isFolderValid($existing->folder_id)) {
            return $existing->folder_id;
        }

        if ($existing) $existing->delete();

        return $this->setupNewDrive($user, $plan, $userDrive);
    }

    private function setupNewDrive(User $user, string $plan, $userDrive): string
    {
        $adminDrive = $this->factory->createAdminDriveService();
        $templates = $this->getTemplatesForPlan($plan);
        $folderId = $userDrive->createFolder("DPJ (" . ucfirst($plan) . ") - {$user->name}");

        $createdIds = [];
        foreach ($templates as $index => $templateId) {
            $adminDrive->shareWithReadAccess($templateId, $user->email);
            $createdIds[] = $userDrive->copyFile($templateId, "Sheet " . ($index + 1), $folderId);
            $adminDrive->revokeAccess($templateId, $user->email);
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
            'pro'     => [env('GOOGLE_TEMPLATE_SHEET_1'), env('GOOGLE_TEMPLATE_SHEET_3'), env('GOOGLE_TEMPLATE_SHEET_4')],
            'enterprise'     => [env('GOOGLE_TEMPLATE_SHEET_1'), env('GOOGLE_TEMPLATE_SHEET_5')],
        ];
        return $map[$plan] ?? $map['free'];
    }
}
