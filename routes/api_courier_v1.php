<?php

use App\Http\Controllers\Api\Courier\V1\CourierController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [CourierController::class, 'login'])->name('login');
