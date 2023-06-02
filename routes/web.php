<?php

use App\Controllers\AuthController;
use App\Controllers\CustomerController;
use Core\Routing\Route;

Route::get('/', function () {
  redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginView']);
Route::post('/login', [AuthController::class, 'attemptLogin']);
Route::get('/register', [AuthController::class, 'register']);


Route::get('/customers/{id}/edit', [CustomerController::class, 'show']);
