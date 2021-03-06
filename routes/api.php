<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductGalleriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SubCategoriesController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VariantsController;
use App\Models\SubCategory;
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
Route::resource('categories', CategoriesController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);

// SubCategoriesController
Route::get('/subcategories/getByCategoryId/{id}', [SubCategoriesController::class, 'getSubCategoryByCategoryId']);
Route::resource('subcategories', SubCategoriesController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);

// UnitsController
Route::resource('units', UnitsController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);

// ProductsController
Route::resource('products', ProductsController::class)->only([
    'index', 'store', 'show', 'update', 'destroy'
]);

// ProductGalleriesController
Route::delete('/remove_image', [ProductGalleriesController::class, 'removeImage']);
