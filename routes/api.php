<?php

use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\seller\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get("/categories", [CategoryController::class, "findAll"]);

Route::get("products", [ProductController::class, "findAll"]);
Route::get("products/category/{categoryId}", [ProductController::class, "findByCategory"]);
Route::get("products/random", [ProductController::class, "findRandom"]);


Route::middleware("auth:sanctum")->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update-quantity/{cartDetail}', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
    Route::post("/payment", [PaymentController::class, "createCharge"])->name('payment');

    Route::get("/seller/orders/{orderId}/details", [OrderController::class, "details"]);
});

// notification midtrans
Route::post('/update-transaction-status', [PaymentController::class, 'updateStatus'])->name('update.transaction.status');
