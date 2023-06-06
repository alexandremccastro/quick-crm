<?php

use App\Controllers\AuthController;
use App\Controllers\CustomerController;
use App\Controllers\HomeController;
use Core\Routing\Route;

Route::get('/', function () {
  return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginView']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'showRegisterView']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/home', [HomeController::class, 'home']);

Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/create', [CustomerController::class, 'create']);
Route::post('/customers', [CustomerController::class, 'save']);
Route::patch('/customers/{id}/favorite', [CustomerController::class, 'favorite']);
Route::get('/customers/favorites', [CustomerController::class, 'favorites']);
Route::get('/customers/{id}/edit', [CustomerController::class, 'edit']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::delete('/customers/{id}', [CustomerController::class, 'delete']);
