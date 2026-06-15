<?php

use App\Http\Controllers\CategoriesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;

Route::view('/', 'welcome')->name('home');
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::get('/users/{id}', [UserController::class, 'show'])
    ->name('users.show')
    ->where('id','[0-9]+');
Route::get('/users/{username}/{email}',[UserController::class,'getUsernameEmail'])
    ->name('users.getUsernameEmail');

Route::get('/categories', [CategoriesController::class, 'index'])
    ->name('categories.index');
Route::get('/categories/create', [CategoriesController::class, 'create'])
    ->name('categories.create');
Route::post('/categories/store', [CategoriesController::class, 'store'])
    ->name('categories.store');
Route::get('/categories/{id}', [CategoriesController::class, 'edit'])
    ->name('categories.edit');
Route::put('/categories/{id}', [CategoriesController::class, 'update'])
    ->name('categories.update');

Route::view('/products', 'products.list')->name('products.index');
Route::view('/products/create', 'products.create')->name('products.create');
Route::view('/products/{product}/edit', 'products.edit')->name('products.edit');
Route::view('/products/{product}', 'products.show')->name('products.show')->where('product', '[0-9]+');

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');