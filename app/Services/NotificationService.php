<?php

namespace App\Services;

use Google_Client;

use Illuminate\Support\Facades\Http;
use Google\Auth\ApplicationDefaultCredentials;

class NotificationService
{
    protected $client;

    protected $apiUrl = 'https://fcm.googleapis.com/v1/projects/laravel-fcm-6a950/messages:send';

    public function __construct()
    {
        $this->client = new Google_Client();

        // Set the credentials
        $this->client->useApplicationDefaultCredentials();

        // Add Firebase messaging scope
        $this->client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        // Load credentials from environment
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path('app/fcm_key.json'));
    }

    public function sendNotification($to, $title, $body)
    {
        // Construct the FCM payload
        $payload = [
            'message' => [
                'token' => $to,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
            ],
        ];

        try {
            // Send the request to Firebase Cloud Messaging API using Laravel HTTP Client
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, $payload);
            // Return the response as a string
            return $response->body();
        } catch (\Exception $e) {
            dd($e);

            // Handle any errors that occur during the HTTP request
            return 'Error sending notification: ' . $e->getMessage();
        }
    }

    private function getAccessToken()
    {
        // Use Google Client to get an access token for Firebase Messaging
        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $token = $client->fetchAccessTokenWithAssertion(    );
        return $token['access_token'];
    }
    private function ensureAccessToken()
    {
        // If the access token is expired or invalid, refresh it
        if ($this->client->isAccessTokenExpired()) {
            // Refresh the access token using the refresh token
            $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
        }
    }
}
