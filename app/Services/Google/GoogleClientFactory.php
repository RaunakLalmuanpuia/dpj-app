<?php

namespace App\Services\Google;

use App\Models\User;
use Google_Client;
use Google_Service_Drive;

class GoogleClientFactory
{
    public function createAdminDriveService(): GoogleDriveService
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/private/google/admin-service-account.json'));
        $client->addScope(Google_Service_Drive::DRIVE);

        return new GoogleDriveService(new Google_Service_Drive($client));
    }

    public function createUserDriveService(User $user): GoogleDriveService
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));

        $client->setAccessToken([
            'access_token' => $user->google_access_token,
            'refresh_token' => $user->google_refresh_token,
        ]);

        if ($client->isAccessTokenExpired()) {
            $token = $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
            $user->update(['google_access_token' => $token['access_token']]);
        }

        return new GoogleDriveService(new Google_Service_Drive($client));
    }
}
