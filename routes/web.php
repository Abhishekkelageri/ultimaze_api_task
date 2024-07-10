<?php

use Illuminate\Support\Facades\Route;

use  App\Http\Controllers\ProductController;
use  App\Http\Controllers\UserController;


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

Route::get('/product/list',[ProductController::class,'list']);

Route::post('/add-to-cart',[ProductController::class,'addToCart'])->name('add.to.cart');
Route::post('/remove',[ProductController::class,'remove'])->name('remove');

Route::get('/list',[ProductController::class,'listProducts']);
Route::post('/addToCart',[ProductController::class,'addCart'])->name('addToCart');
Route::post('/delete',[ProductController::class,'delete'])->name('delete');

Route::get('/home', function(){
    return view('home');
});

Route::post('/addusers',[UserController::class,'storeUsers'])->name('store');