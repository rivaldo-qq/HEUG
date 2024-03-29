<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CategoriesDetailController;
use App\Http\Controllers\CategoriesGalleryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MyTransactionController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TableGalleryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\TableGallery;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/details/{slug}', [FrontendController::class, 'details'])->name('details');
Route::get('/table/{slug}', [FrontendController::class, 'TableDetails'])->name('Table-Details');
Route::get('/categories}', [CategoriesDetailController::class, 'index'])->name('categories');
Route::get('/categories/{slug}', [CategoriesDetailController::class, 'details'])->name('categories-details');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
    Route::post('/cart/{id}', [FrontendController::class, 'cartAdd'])->name('cart-add');
    Route::delete('/cart/{id}', [FrontendController::class, 'cartDelete'])->name('cart-delete');
    Route::post('/checkout', [FrontendController::class, 'checkout'])->name('checkout');
    Route::post('/bayarkasir', [FrontendController::class, 'bayarkasir'])->name('bayarkasir');
    Route::get('/bayarcash', [FrontendController::class, 'formcash'])->name('bayarcash');
    Route::get('/bayaronline', [FrontendController::class, 'formonline'])->name('bayaronline');
    Route::get('/checkout/success', [FrontendController::class, 'success'])->name('checkout-success');


    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::resource('my-transaction', MyTransactionController::class)->only([
            'index', 'show'
        ]);

        Route::middleware(['admin'])->group(function () {
            Route::resource('product', ProductController::class);
            Route::resource('table', TableController::class);
            Route::resource('product.gallery', ProductGalleryController::class)->shallow()->only([
                'index', 'create', 'store', 'destroy'
            ]);
            Route::resource('table.table-gallery', TableGalleryController::class)->shallow()->only([
                'index', 'create', 'store', 'destroy'
            ]);
            Route::resource('categories.categories-gallery', CategoriesGalleryController::class)->shallow()->only([
                'index', 'create', 'store', 'destroy'
            ]);
            Route::resource('transaction', TransactionController::class)->only([
                'index', 'show', 'edit', 'update'
            ]);
            Route::resource('user', UserController::class)->only([
                'index', 'edit', 'update', 'destroy'
            ]);
            Route::resource('categories', CategoriesController::class);
        });
    });
});
