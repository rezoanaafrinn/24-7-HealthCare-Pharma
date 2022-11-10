<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BuyerAuthController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
Route::get('/', [ProductController::class, 'productList'])->name('products.list');
Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('remove', [CartController::class, 'removeCart'])->name('cart.remove');
Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
Route::post('checkout', [CartController::class, 'checkout'])->name('checkout')->middleware('isLoggedIn');
//////////registration//////////
Route::get('/login',[BuyerAuthController::class,'login']);
Route::get('/registration',[BuyerAuthController::class,'registration'])->name('registration');
Route::post('/register-buyer',[BuyerAuthController::class,'registerBuyer'])->name ('register-buyer');
Route::post('/login-buyer',[BuyerAuthController::class,'loginBuyer'])->name ('login-buyer');
Route::get('/profile',[BuyerAuthController::class,'profile'])->middleware('isLoggedIn');
Route::get('/logout',[BuyerAuthController::class,'logout']);