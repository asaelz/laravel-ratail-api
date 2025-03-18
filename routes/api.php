<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\customerController;

Route::get('/clientes', [customerController::class, 'index']);

Route::get('/clientes/{id}', [customerController::class, 'getCustomer']);


Route::post('/clientes', [customerController::class, 'saveCustomer']);

Route::put('/clientes/{id}', [customerController::class, 'updateCustomer']);

Route::delete('/clientes/{id}', [customerController::class, 'deleteCustomer']);