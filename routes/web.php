<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
Route::inertia('/', 'Welcome')->name('home');
Route::resource('users', UserController::class);
Route::resource('roles', RolController::class);

