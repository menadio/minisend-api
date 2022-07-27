<?php

use App\Http\Controllers\ApiKeyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StatusController;

Route::post('register', RegisterController::class); // regiester new user

Route::post('login', LoginController::class); // login

Route::post('send', [EmailController::class, 'send'])
    ->middleware('apiKey'); // send email

Route::middleware('auth:sanctum')->group(function () {

    Route::get('user', UserController::class); // user details

    Route::get('api-key', [ApiKeyController::class, 'fetch']); // get api key

    Route::get('emails', [EmailController::class, 'index']); // fetch sent emails

    Route::get('emails/{email}', [EmailController::class, 'show']); // fetch sent emails

    Route::post('logout', LogoutController::class); // logout
});

Route::get('statuses', StatusController::class); // fetch list of status
