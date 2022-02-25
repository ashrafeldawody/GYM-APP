<?php

use Illuminate\Support\Facades\Auth;
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
Route::prefix('dashboard')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/users', function () {
        return "here";
    })->name('users');
});

Route::get('/', function () {
    return redirect()->route('admin.users');
});


//Auth::routes();
//
//
//Route::middleware(['auth'])->group(function () {
//
//
//
//    Route::get('/', function () {
//        return view('home');
//    });
//
//    Route::get('/user/profile', []);
//});

