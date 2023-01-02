<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CourierController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\Admin\TagController;
use App\Models\Foods\Ingredient;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProviderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [AdminController::class, 'index'])->middleware('auth')->name('admin.index');

// користувачі
Route::prefix('user')->middleware('role')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::get('/{user}/reload', [UserController::class, 'reload'])->name('user.reload');
    Route::patch('/{user}', [UserController::class, 'update'])->name('user.update');
    Route::get('/{user}/show', [UserController::class, 'show'])->name('user.show');
    Route::get('/{user}/history', [UserController::class, 'history'])->name('user.history');
    Route::post('/active', [UserController::class, 'active'])->name('user.active');
    Route::post('/', [UserController::class, 'store'])->name('user.store');
    Route::get('/{user}/delete', [UserController::class, 'delete'])->name('user.delete');
});

// заклади
Route::prefix('provider')->middleware('role')->group(function () {
    Route::get('/', [ProviderController::class, 'index'])->name('provider.index');
    Route::get('/create', [ProviderController::class, 'create'])->name('provider.create');
    Route::get('/{provider}/edit', [ProviderController::class, 'edit'])->name('provider.edit');
    Route::patch('/{provider}', [ProviderController::class, 'update'])->name('provider.update');
    Route::get('/{provider}/show', [ProviderController::class, 'show'])->name('provider.show');
    Route::get('/{provider}/history', [ProviderController::class, 'history'])->name('provider.history');
    Route::post('/', [ProviderController::class, 'store'])->name('provider.store');
    Route::get('/{provider}/delete', [ProviderController::class, 'delete'])->name('provider.delete');

    // страви
    Route::get('/food/{provider}', [FoodController::class, 'index'])->name('food.index');
    Route::get('/food/{provider}/create', [FoodController::class, 'create'])->name('food.create');
    Route::get('/food/{food}/edit', [FoodController::class, 'edit'])->name('food.edit');
    Route::patch('/food/{food}', [FoodController::class, 'update'])->name('food.update');
    Route::get('/food/{food}/show', [FoodController::class, 'show'])->name('food.show');
    Route::get('/food/{food}/history', [FoodController::class, 'history'])->name('food.history');
    Route::post('/food', [FoodController::class, 'store'])->name('food.store');
    Route::get('/food/{food}/delete', [FoodController::class, 'delete'])->name('food.delete');

    // інгредієнти
    Route::get('/ingredient/{food}', [IngredientController::class, 'index'])->name('ingredient.index');
    Route::patch('/ingredient/{ingredient}', [IngredientController::class, 'update'])->name('ingredient.update');
    Route::get('/ingredient/{ingredient}/history', [IngredientController::class, 'history'])->name('ingredient.history');
    Route::get('/ingredient/{ingredient}/delete', [IngredientController::class, 'delete'])->name('ingredient.delete');
    Route::post('/ingredient/store', [IngredientController::class, 'store'])->name('ingredient.store');
    Route::post('/ingredient/create', [IngredientController::class, 'create'])->name('ingredient.create');
});

// теги
Route::prefix('tag')->middleware('role')->group(function () {
    Route::get('/', [TagController::class, 'index'])->name('tag.index');
    Route::get('/create', [TagController::class, 'create'])->name('tag.create');
    Route::get('/{tag}/edit', [TagController::class, 'edit'])->name('tag.edit');
    Route::get('/{tag}/history', [TagController::class, 'history'])->name('tag.history');
    Route::patch('/{tag}', [TagController::class, 'update'])->name('tag.update');
    Route::post('/', [TagController::class, 'store'])->name('tag.store');
    Route::get('/{tag}/delete', [TagController::class, 'delete'])->name('tag.delete');
});

// на модерації
Route::prefix('moderation')->middleware('role')->group(function () {
    Route::get('/', [ModerationController::class, 'index'])->name('moderation.index');
    Route::patch('/', [ModerationController::class, 'update'])->name('moderation.update');
});

// клієнти
Route::prefix('client')->middleware('role')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('client.index');
    Route::get('/create', [ClientController::class, 'create'])->name('client.create');
    Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('client.edit');
    Route::patch('/{client}', [ClientController::class, 'update'])->name('client.update');
    Route::get('/{client}/show', [ClientController::class, 'show'])->name('client.show');
    Route::get('/{client}/history', [ClientController::class, 'history'])->name('client.history');
    Route::post('/active', [ClientController::class, 'active'])->name('client.active');
    Route::post('/', [ClientController::class, 'store'])->name('client.store');
    Route::get('/{client}/delete', [ClientController::class, 'delete'])->name('client.delete');
});

// кур'єри
Route::prefix('courier')->middleware('role')->group(function () {
    Route::get('/', [CourierController::class, 'index'])->name('courier.index');
    Route::get('/create', [CourierController::class, 'create'])->name('courier.create');
    Route::get('/{courier}/edit', [CourierController::class, 'edit'])->name('courier.edit');
    Route::patch('/{courier}', [CourierController::class, 'update'])->name('courier.update');
    Route::get('/{courier}/show', [CourierController::class, 'show'])->name('courier.show');
    Route::get('/{courier}/history', [CourierController::class, 'history'])->name('courier.history');
    Route::post('/active', [CourierController::class, 'active'])->name('courier.active');
    Route::post('/', [CourierController::class, 'store'])->name('courier.store');
    Route::get('/{courier}/delete', [CourierController::class, 'delete'])->name('courier.delete');
});

Route::get('/login', function (){
    if(Auth::check()) return redirect(route('admin.index'));
    return view('login');
})->name('login');
Route::post('/login',[LoginController::class, 'login']);
Route::get('/logout',function (){
    Auth::logout();
    return redirect('/');
})->name('logout');
