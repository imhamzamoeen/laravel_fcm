<?php

use App\Http\Controllers\NotificationSendController;
use Illuminate\Support\Facades\Route;
use Kreait\Firebase\Factory;

Route::get('/', function () {
    $factory = (new Factory)
        ->withServiceAccount(storage_path('app/fcm_key.json'))
        ->withDatabaseUri('https://my-project-default-rtdb.firebaseio.com');
        $auth = $factory->createAuth();
    dd($auth);
    return view('welcome');
});

Auth::routes();
Route::post('/send-notification', [NotificationSendController::class, 'sendNotification'])->name('send.web-notifications');;

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => 'auth'], function () {
    Route::post('/store-token', [NotificationSendController::class, 'updateDeviceToken'])->name('store.token');
    Route::post('/send-web-notification', [NotificationSendController::class, 'sendNotification'])->name('send.web-notification');
});
