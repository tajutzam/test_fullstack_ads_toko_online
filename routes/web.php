<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\seller\DashboardController;
use App\Http\Controllers\seller\OrderController;
use App\Http\Controllers\seller\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, "index"]);
Route::get('/product/category/{id}', [HomeController::class, "findByCategory"])->name('product.category');



Route::get("/login", [AuthController::class, "loginView"])->name('login');
Route::get("/register", [AuthController::class, "registerView"]);

Route::post("/register", [AuthController::class, "register"])->name('registerPost');
Route::post("/login", [AuthController::class, "login"])->name('loginPost');

Route::middleware(["auth:sanctum", "role:seller"])->prefix("/seller")->name('seller.')->group(function () {
    Route::get("/dashboard", [DashboardController::class, "index"])->name('dashboard');
    Route::resource("/products", ProductController::class);
    Route::put('/orders/{id}/update-status', [OrderController::class, 'updateStatus']);
    Route::get("/orders", [OrderController::class, "index"])->name('orders');
});

Route::middleware(["auth:sanctum", "role:user"])->prefix("/")->name('user.')->group(function () {
    Route::get("/dashboard", [HomeController::class, "dashboard"]);
    Route::get("/profile", [UserController::class, "index"])->name('profile');
    Route::put("/profile", [UserController::class, "update"])->name('profile.update');
    Route::get("/cart", [CartController::class, "index"])->name('cart');
    Route::put('/seller/orders/{id}/update-status/done', [OrderController::class, 'updateStatusDone'])->name('order.done');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post("/logout", [AuthController::class, "logout"])->name('logout');
});
