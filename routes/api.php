<?php

use App\Http\Controllers\Api\BusinessController;
use App\Http\Controllers\Api\CarouselController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(CategoryController::class)->group(function () {
    Route::apiResource('category', CategoryController::class)->parameters([
        'categories' => 'category:category_url',
    ])->only(['index', 'show']);

    // The category with products
    
    Route::get('/category_products', 'category_products')->name('category.products');
    Route::get('/category_products/{category}', 'category_products_slug')->name('category.products.slug');

});


Route::controller(ProductController::class)->group(function () {
    Route::apiResource('products', ProductController::class)->parameters([
        'products' => 'product:product_url',
    ]);

    Route::get('related_products/{product_id}/{category_id}', 'related_products')->name('category.related.products');

});



Route::get('/business', [BusinessController::class,'index'])->name('business');
Route::get('/carousel', [CarouselController::class,'index'])->name('carousel');
Route::get('/gallery', [GalleryController::class,'index'])->name('gallery');
Route::get('/clients', [ClientController::class,'index'])->name('clients');




