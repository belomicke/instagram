<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\User\CreateUserController;
use App\Http\Controllers\User\GetEmailIsTakenStatusController;
use App\Http\Controllers\User\GetUsernameIsTakenStatusController;
use App\Http\Controllers\Viewer\GetViewerController;
use Illuminate\Support\Facades\Route;

Route::prefix("auth")->group(function () {
    Route::middleware("auth:sanctum")->group(function () {
        Route::get('viewer', GetViewerController::class);
    });

    Route::post('/sign_in', LoginController::class);
    Route::post('/sign_up', CreateUserController::class);

    Route::delete('/logout', LogoutController::class);
});


Route::prefix("users")->group(function () {
    Route::get("email/exists", GetEmailIsTakenStatusController::class);
    Route::get("username/exists", GetUsernameIsTakenStatusController::class);
});
