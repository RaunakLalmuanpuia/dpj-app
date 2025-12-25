<?php

namespace App\Services\Google;

use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;

class GoogleDriveService
{
    protected $service;

    public function __construct(Google_Service_Drive $service)
    {
        $this->service = $service;
    }

    public function createFolder(string $name): string
    {
        $folder = $this->service->files->create(new Google_Service_Drive_DriveFile([
            'name' => $name,
            'mimeType' => 'application/vnd.google-apps.folder',
        ]), ['fields' => 'id']);

        return $folder->id;
    }

    public function copyFile(string $fileId, string $newName, string $folderId): string
    {
        $copy = $this->service->files->copy($fileId, new Google_Service_Drive_DriveFile(['name' => $newName]));

        $this->service->files->update($copy->id, new Google_Service_Drive_DriveFile(), [
            'addParents' => $folderId,
            'removeParents' => 'root',
        ]);

        return $copy->id;
    }

    public function shareWithReadAccess(string $fileId, string $email): void
    {
        $permission = new Google_Service_Drive_Permission([
            'type' => 'user',
            'role' => 'reader',
            'emailAddress' => $email,
        ]);
        $this->service->permissions->create($fileId, $permission, ['sendNotificationEmail' => false]);
    }

    public function revokeAccess(string $fileId, string $email): void
    {
        $permissions = $this->service->permissions->listPermissions($fileId);
        foreach ($permissions as $permission) {
            if ($permission->emailAddress === $email) {
                $this->service->permissions->delete($fileId, $permission->id);
            }
        }
    }

    public function isFolderValid(string $folderId): bool
    {
        try {
            $file = $this->service->files->get($folderId, ['fields' => 'id, trashed']);
            return !$file->getTrashed();
        } catch (\Exception $e) {
            return false;
        }
    }
}
