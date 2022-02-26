<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;

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
    return redirect()->route('admin.home');
});

Route::prefix('dashboard')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
});


Route::prefix('purchases')->middleware('auth')->name('purchases.')->group(function() {
   Route::get('/', [PurchaseController::class, 'index'])->name('index');
   Route::get('/create', [PurchaseController::class, 'create'])->name('create');
   Route::post('/', [PurchaseController::class, 'store'])->name('store');
});

Auth::routes();


