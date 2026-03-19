<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatIAController;
Route::inertia('/', 'Welcome')->name('home');
Route::resource('users', UserController::class);
Route::resource('roles', RolController::class);
Route::inertia('/chat-ia', 'ChatIA')->name('chat-ia');
Route::post('/chat-ia', [ChatIAController::class, 'chat'])->name('chat-ia.send');