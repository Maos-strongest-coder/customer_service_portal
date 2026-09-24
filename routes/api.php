<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketReplyController;
use App\Http\Controllers\TicketNoteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

// apiresources moeten alle crud accounted for hebben
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');

    Route::middleware('verified')->group(function () {
        Route::apiResource('users', UserController::class);

        Route::apiResource('categories', CategoryController::class)->except('show');

        Route::apiResource('tickets', TicketController::class);

        Route::apiResource('tickets.replies', TicketReplyController::class)
            ->only(['store', 'update'])
            ->scoped();

        Route::apiResource('tickets.notes', TicketNoteController::class)
            ->except(['show'])
            ->scoped();
    });
});

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/register', [RegisterController::class, 'register']);
