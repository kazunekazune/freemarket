<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;

Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/sell', [ItemController::class, 'create'])->name('items.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('items.store');
    Route::post('/item/{item}/like', [App\Http\Controllers\LikeController::class, 'store'])->name('items.like');
    Route::delete('/item/{item}/like', [App\Http\Controllers\LikeController::class, 'destroy'])->name('items.unlike');
    Route::post('/item/{item}/comment', [App\Http\Controllers\ItemController::class, 'comment'])->name('items.comment');
    Route::post('/purchase/{item}', [App\Http\Controllers\PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/mypage', [App\Http\Controllers\ProfileController::class, 'mypage'])->name('mypage');
    Route::get('/item/{item}/edit', [App\Http\Controllers\ItemController::class, 'edit'])->name('items.edit');
    Route::put('/item/{item}', [App\Http\Controllers\ItemController::class, 'update'])->name('items.update');
    Route::delete('/item/{item}', [App\Http\Controllers\ItemController::class, 'destroy'])->name('items.destroy');
});

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

