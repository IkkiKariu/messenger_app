<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\MessageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function()
{
   return "<h1>Home</h1>"; 
})->name('home');

Route::prefix('/users')->group(function() {
    Route::get('/register', [RegistrationController::class, 'index'])->name('register.index');
    Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

    Route::get('/login', [AuthenticationController::class, 'index'])->name('login.index');
    Route::post('/login', [AuthenticationController::class, 'store'])->name('login.store');
});

Route::prefix('/messages')->group(function() {
    Route::get('/index', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/create', [MessageController::class, 'store'])->name('messages.create.store');
});