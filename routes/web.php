<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TrainingPackageController;
use App\Http\Controllers\TrainingSessionController;
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

Route::prefix('attendance')->middleware('auth')->name('attendance.')->group(function() {
    Route::get('/', [AttendanceController::class, 'index'])->name('index');
});

Route::prefix('training_packages')->middleware('auth')->name('training_packages.')->group(function() {
    Route::get('/', [TrainingPackageController::class, 'index'])->name('index');
    Route::get('/create', [TrainingPackageController::class, 'create'])->name('create');
    Route::post('/', [TrainingPackageController::class, 'store'])->name('store');
    Route::get('/{package}', [TrainingPackageController::class, 'show'])->name('show');
    Route::get('/{package}/edit', [TrainingPackageController::class, 'edit'])->name('edit');
    Route::patch('/{package}', [TrainingPackageController::class, 'update'])->name('update');
    Route::delete('/{package}', [TrainingPackageController::class, 'destroy'])->name('destroy');
});

Route::prefix('training_sessions')->middleware('auth')->name('training_sessions.')->group(function() {
    Route::get('/', [TrainingSessionController::class, 'index'])->name('index');
    Route::get('/create', [TrainingSessionController::class, 'create'])->name('create');
    Route::post('/', [TrainingSessionController::class, 'store'])->name('store');
    Route::get('/{session}', [TrainingSessionController::class, 'show'])->name('show');
    Route::get('/{session}/edit', [TrainingSessionController::class, 'edit'])->name('edit');
    Route::patch('/{session}', [TrainingSessionController::class, 'update'])->name('update');
    Route::delete('/{session}', [TrainingSessionController::class, 'destroy'])->name('destroy');
});

Auth::routes();


