<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketReplyController;
use App\Http\Controllers\TicketNoteController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/tickets', [TicketController::class, 'index']);

    Route::post('/tickets', [TicketController::class, 'store']);

    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);

    Route::post('/tickets/{ticket}/replies', [TicketReplyController::class, 'store']);

    Route::put('/tickets/{ticket}/replies/{reply}', [TicketReplyController::class, 'update']);

    Route::get('/tickets/{ticket}/notes', [TicketNoteController::class, 'index']);
    Route::post('/tickets/{ticket}/notes', [TicketNoteController::class, 'store']);
    Route::put('/tickets/{ticket}/notes/{note}', [TicketNoteController::class, 'update']);
    Route::delete('/tickets/{ticket}/notes/{note}', [TicketNoteController::class, 'destroy']);

    Route::get('/categories', [CategoryController::class, 'index']);

    Route::post('/logout', [LoginController::class, 'logout']);
});



Route::middleware('')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
});
