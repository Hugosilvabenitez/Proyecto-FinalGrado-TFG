<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatIAController;
use App\Http\Controllers\GameSessionController;
use App\Http\Controllers\AchievementController;

/***********************
 * RUTAS PRINCIPALES
 ***********************/
Route::inertia('/', 'Welcome')->name('home');
Route::resource('users', UserController::class);
Route::resource('roles', RolController::class);
Route::inertia('/chat-ia', 'ChatIA')->name('chat-ia');
Route::post('/chat-ia', [ChatIAController::class, 'chat'])->name('chat-ia.send');
Route::middleware('auth')->group(function () {
    Route::post('/game-sessions',       [GameSessionController::class, 'store'])->name('game-sessions.store');
    Route::post('/game-sessions/score', [GameSessionController::class, 'reportScore'])->name('game-sessions.score');
    Route::get('/achievements',         [AchievementController::class, 'index'])->name('achievements.index');
});