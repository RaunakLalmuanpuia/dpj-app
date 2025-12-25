<?php


namespace App\Services;

use App\Models\User;
use App\Models\UserGoogleDrive;
use App\Services\Google\GoogleClientFactory;
use App\Services\Google\GoogleDriveService;

class UserDriveSetupService
{
    protected $clientFactory;

    public function __construct(GoogleClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function getOrCreateUserFolder(User $user, string $plan): string
    {
        $existing = UserGoogleDrive::where('user_id', $user->id)->where('plan_type', $plan)->first();
        $userDrive = new GoogleDriveService(new \Google_Service_Drive($this->clientFactory->createUserClient($user)));

        if ($existing && $userDrive->isFolderValid($existing->folder_id)) {
            return $existing->folder_id;
        }

        if ($existing) $existing->delete();

        return $this->setupNewDrive($user, $plan, $userDrive);
    }

    private function setupNewDrive(User $user, string $plan, GoogleDriveService $userDrive): string
    {
        $adminDrive = new GoogleDriveService(new \Google_Service_Drive($this->clientFactory->createAdminClient()));

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
            'essential' => [env('GOOGLE_TEMPLATE_SHEET_1'), env('GOOGLE_TEMPLATE_SHEET_2')],
            'habit'     => [env('GOOGLE_TEMPLATE_SHEET_1'), env('GOOGLE_TEMPLATE_SHEET_3'), env('GOOGLE_TEMPLATE_SHEET_4')],
            'focus'     => [env('GOOGLE_TEMPLATE_SHEET_1'), env('GOOGLE_TEMPLATE_SHEET_5')],
            'legacy'    => [env('GOOGLE_TEMPLATE_SHEET_1'), env('GOOGLE_TEMPLATE_SHEET_2'), env('GOOGLE_TEMPLATE_SHEET_3'), env('GOOGLE_TEMPLATE_SHEET_4')],
        ];
        return $map[$plan] ?? $map['essential'];
    }
}
