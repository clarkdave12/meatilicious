<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VariantsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// UsersController
Route::get('/is_admin', [UsersController::class, 'isAdmin'])->middleware('auth:api');
Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);
Route::post('/admin/login', [UsersController::class, 'adminLogin']);

// CategoriesController
Route::get('/categories/products/{id}', [CategoriesController::class, 'getProducts']);
Route::resource('categories', CategoriesController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);

// ProductsController
Route::resource('products', ProductsController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);

// VariantsController
Route::resource('variants', VariantsController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);
