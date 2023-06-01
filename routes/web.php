<?php

use App\Controllers\AuthController;
use App\Controllers\CustomerController;
use Core\Routing\Route;


Route::post('/login', [AuthController::class, 'login']);


Route::get('/customers/{id}/edit', [CustomerController::class, 'show']);
