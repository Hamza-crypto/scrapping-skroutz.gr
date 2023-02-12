<?php

use App\Http\Controllers\DatatableController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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
Route::redirect('/', '/products');

Route::group([], function () {
//    Route::get('products', [ProductController::class, 'index'])->name('product.index');
//    Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
//    Route::post('product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('scrape', [ProductController::class, 'scrape'])->name('product.scrape');
    Route::put('softcap/{product}', [ProductController::class, 'softcap'])->name('soft_cap.update');
    Route::put('status/{product}', [ProductController::class, 'ignore_status'])->name('status.update');

    Route::resource('products', ProductController::class);

    Route::get('api/v1/products', [DatatableController::class, 'products'])->name('products.ajax');
});


Route::get('products/export', [ProductController::class, 'exports'])->name('products.export');




