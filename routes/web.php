<?php

use App\Controllers\AuthController;
use App\Controllers\CustomerController;
use App\Controllers\HomeController;
use Core\Routing\Route;

Route::get('/', function () {
  redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginView']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'showRegisterView']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/home', [HomeController::class, 'home']);

Route::get('/customers/{id}/edit', [CustomerController::class, 'show']);
