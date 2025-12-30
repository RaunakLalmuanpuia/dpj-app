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

    /**
     * Create a Folder
     */
    public function createFolder(string $name): string
    {
        $folder = $this->service->files->create(new Google_Service_Drive_DriveFile([
            'name' => $name,
            'mimeType' => 'application/vnd.google-apps.folder',
        ]), ['fields' => 'id']);

        return $folder->id;
    }

    /**
     * Create a file from content (Upload)
     * Automatically converts Excel/CSV content to Google Sheets if mimeType matches.
     */
    public function createFile(string $name, string $parentId, string $content, string $contentType): string
    {
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $name,
            'parents' => [$parentId],
            // improving compatibility: explicitly ask Google to convert to Sheet
            'mimeType' => 'application/vnd.google-apps.spreadsheet'
        ]);

        $file = $this->service->files->create(
            $fileMetadata,
            [
                'data' => $content,
                'mimeType' => $contentType, // The mimeType of the data being uploaded (e.g., Excel)
                'uploadType' => 'multipart',
                'fields' => 'id'
            ]
        );

        return $file->id;
    }

    /**
     * Export a Google Doc/Sheet to a binary string (e.g., as Excel)
     */
    public function exportFile(string $fileId, string $mimeType): string
    {
        // 'alt' => 'media' tells Google to download the content
        $response = $this->service->files->export($fileId, $mimeType, ['alt' => 'media']);

        return (string) $response->getBody();
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
