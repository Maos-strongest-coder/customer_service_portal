<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/tickets', [TicketController::class, 'index']);

    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);

    Route::post('/logout', [LoginController::class, 'logout']);
});



Route::middleware('')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
});
