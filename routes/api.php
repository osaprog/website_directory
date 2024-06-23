<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VoteController;
use App\Http\Controllers\Api\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::get('websites', [WebsiteController::class, 'index']);
Route::get('websites/search', [WebsiteController::class, 'search']);
Route::get('websites/search_engine', [WebsiteController::class, 'search_engine']);

// Authenticated User Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('websites', [WebsiteController::class, 'store']);
    Route::delete('websites/{website}', [WebsiteController::class, 'destroy']);
    Route::post('websites/{website}/vote', [VoteController::class, 'vote']);
    Route::delete('/websites/{website}/unvote', [VoteController::class, 'unvote']);
});
