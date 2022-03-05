<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CityManagerController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\GeneralManagerController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\GymManagerController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\StripeController;
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
    return redirect()->route('dashboard.');
});

Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function () {

    Route::get('/', [PurchaseController::class, 'index'])->middleware('permission:purchases');

    Route::resource('cities', CityController::class)->middleware('permission:cities');
    Route::get('/cities-form-data', [CityController::class, 'getFormData'])->name('cities.formData')->middleware('permission:cities');

    Route::resource('gyms', GymController::class)->middleware('permission:gyms');
    Route::get('/gyms-form-data', [GymController::class, 'getFormData'])->name('gyms.formData')->middleware('permission:gyms');;

    Route::resource('city-managers', CityManagerController::class)->middleware('permission:city_managers');
    Route::get('/city-managers-form-data', [CityManagerController::class, 'getFormData'])->name('city-managers.formData')->middleware('permission:city_managers');

    Route::resource('gym_managers', GymManagerController::class)->middleware('permission:gym_managers');
    Route::get('/gym_managers-form-data', [GymManagerController::class, 'getFormData'])  ->name('gym_managers.formData')->middleware('permission:gym_managers');

    Route::resource('general_managers', GeneralManagerController::class)->middleware('permission:general_managers');
    Route::get('/general_managers-form-data', [GeneralManagerController::class, 'getFormData'])->name('general_managers.formData')->middleware('permission:general_managers');

    Route::resource('coaches', CoachController::class)->middleware('permission:coaches');
    Route::get('/coaches-form-data', [CoachController::class, 'getFormData'])->name('coaches.formData')->middleware('permission:coaches');

    Route::resource('users', UserController::class)->middleware('permission:users');
    Route::get('/users-form-data', [UserController::class, 'getFormData'])->name('users.formData')->middleware('permission:users');

    Route::resource('sessions', SessionsController::class)->middleware('permission:sessions');
    Route::get('/sessions-form-data', [SessionsController::class, 'getFormData'])->name('sessions.formData')->middleware('permission:sessions');

    Route::resource('attendance', AttendanceController::class)->only(['index', 'create', 'update'])->middleware('permission:attendance');
    Route::get('/attendance-form-data', [AttendanceController::class, 'getFormData'])->name('attendance.formData')->middleware('permission:attendance');

    Route::resource('packages', PackagesController::class)->middleware('permission:packages');

    Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store'])->middleware('permission:purchases');


    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [ManagerController::class,'index'])->name('index');
        Route::put('/update-basic', [ManagerController::class,'updateBasicInformation'])->name('update-basic');
        Route::put('/update-password', [ManagerController::class,'updatePassword'])->name('update-password');
    });

});

Auth::routes();
