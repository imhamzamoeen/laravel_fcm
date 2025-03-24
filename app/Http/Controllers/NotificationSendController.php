<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Kreait\Firebase\Factory;
use App\Services\NotificationService;

class NotificationSendController extends Controller
{
    public function updateDeviceToken(Request $request)
    {
        $request->user()->save([
            'device_token' =>  $request->token
        ]);


        return response()->json(['Token successfully stored.']);
    }

    protected $fcmService;

    public function __construct(NotificationService $fcmService)
    {
        $this->fcmService = $fcmService;
    }

    public function sendNotification()
    {
        $to = 'fyVaY5p8Dj7YLtuwkdXZLb:APA91bFqdgECPlU3EazSh7WVYm9EeSZExp62WG4Rft5NZaeT8oUx-IJt9Lfr6iChY8jYhlCQ9VOsOU4g8DsaUys0NI9nu3bHk6_aZHcQ9qB83UGa9bmYSy0'; // Replace with the recipient's FCM token
        $title = 'Hello from Laravel!';
        $body = 'This is a test notification sent using Laravel HTTP Client and Firebase Cloud Messaging.';

        $response = $this->fcmService->sendNotification($to, $title, $body);

        return response()->json([
            'message' => 'Notification sent!',
            'response' => $response
        ]);
    }}
