<?php

use App\Http\Controllers\Api\User\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login'])->name('login');

