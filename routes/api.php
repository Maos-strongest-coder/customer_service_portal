<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketReplyController;
use App\Http\Controllers\TicketNoteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

// apiresources moeten alle crud accounted for hebben
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/users', [UserController::class, 'index']);

    Route::apiResource('categories', CategoryController::class)->only('index');
    Route::apiResource('tickets', TicketController::class)->except('destroy');

    Route::apiResource('tickets.replies', TicketReplyController::class)
        ->only(['store', 'update'])
        ->scoped();

    Route::apiResource('tickets.notes', TicketNoteController::class)
        ->except(['show'])
        ->scoped();

    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::post('/login', [LoginController::class, 'login']);

Route::post('/register', [RegisterController::class, 'register']);

