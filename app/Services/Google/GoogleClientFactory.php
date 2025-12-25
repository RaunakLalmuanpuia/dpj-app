<?php

namespace App\Services\Google;

use App\Models\User;
use Google_Client;

class GoogleClientFactory
{
    public function createAdminClient(): Google_Client
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/private/google/admin-service-account.json'));
        $client->addScope(\Google_Service_Drive::DRIVE);
        return $client;
    }

    public function createUserClient(User $user): Google_Client
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

        return $client;
    }
}
