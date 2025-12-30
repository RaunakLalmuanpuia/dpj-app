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
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $newName,
            'parents' => [$folderId]
        ]);

        $copy = $this->service->files->copy($fileId, $fileMetadata);

        return $copy->id;
    }

    public function share(string $fileId, string $email, string $role = 'reader'): void
    {
        $permission = new Google_Service_Drive_Permission([
            'type' => 'user',
            'role' => $role,
            'emailAddress' => $email,
        ]);

        $this->service->permissions->create($fileId, $permission, ['sendNotificationEmail' => false]);
    }

    public function revokeAccess(string $fileId, string $email): void
    {
        try {
            // Request emailAddress field specifically to ensure we can match it
            $permissions = $this->service->permissions->listPermissions($fileId, [
                'fields' => 'permissions(id, emailAddress)'
            ]);

            foreach ($permissions as $permission) {
                if ($permission->emailAddress === $email) {
                    $this->service->permissions->delete($fileId, $permission->id);
                }
            }
        } catch (\Exception $e) {
            // Permission might already be gone
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

    public function emptyTrash(): void
    {
        $this->service->files->emptyTrash();
    }
}
