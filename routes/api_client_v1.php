<?php

use App\Http\Controllers\Api\Client\V1\CityController;
use App\Http\Controllers\Api\Client\V1\ClientController;
use App\Http\Controllers\Api\Client\V1\FoodController;
use App\Http\Controllers\Api\Client\V1\IngredientController;
use App\Http\Controllers\Api\Client\V1\SearchController;
use App\Http\Controllers\Api\Client\V1\TagController;
use App\Http\Controllers\Api\Client\V1\PromoteController;
use App\Http\Controllers\Api\Client\V1\ProviderController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ClientController::class, 'login'])->name('login');
Route::get('/tags', [TagController::class, 'tags'])->name('tags');
Route::get('/providers/{city}', [ProviderController::class, 'providers'])->name('providers');
Route::get('/provider/{id}', [ProviderController::class, 'provider'])->name('provider');
Route::get('/provider/{id}/tags/', [ProviderController::class, 'tags'])->name('providerTags');
Route::get('/provider/{id}/foods/', [ProviderController::class, 'foods'])->name('providerFoods');
Route::get('/promotes/{city}', [PromoteController::class, 'promotes'])->name('promotes');
Route::get('/cities', [CityController::class, 'cities'])->name('cities');
Route::get('/search/{city}', [SearchController::class, 'search'])->name('search');
Route::get('/foodbyname/{city}', [SearchController::class, 'foodbyname'])->name('foodbyname');
Route::get('/foods/{city}', [FoodController::class, 'foods'])->name('foods');
Route::get('/foods/{city}/tag/{id}', [FoodController::class, 'foodsTag'])->name('foodsTag');
Route::get('/food/{id}', [FoodController::class, 'food'])->name('food');
Route::get('/ingredients/{id}', [IngredientController::class, 'ingredients'])->name('ingredients');



//Route::get('/provider/{city}', [ProviderController::class, 'provider'])->middleware('auth_api')->name('provider');
