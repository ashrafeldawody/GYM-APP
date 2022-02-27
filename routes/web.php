<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TrainingPackageController;
use App\Http\Controllers\TrainingSessionController;
use App\Http\Controllers\UserController;
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

Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function () {

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::resource('cities', CityController::class);

    Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store']);

    Route::resource('attendance', AttendanceController::class)->only(['index']);

    Route::resource('packages', TrainingPackageController::class);

    Route::resource('sessions', TrainingSessionController::class);

    Route::resource('users', UserController::class);
});



Auth::routes();
