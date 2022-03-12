<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CityManagerController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\GeneralManagerController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\GymManagerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
use App\Models\User;
use App\Mail\WelcomeMember;
use App\Mail\VerifyEmail;
use App\Mail\ForgotPassword;
use App\Mail\WeMissYou;

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
    return redirect()->route('dashboard.home.index');
});

Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->middleware('permission:purchases')->name('home.index');;
    Route::get('/home/charts/male-female-attendance', [HomeController::class, 'maleFemaleAttendanceData'])->middleware('permission:purchases')->name('charts.male-female-attendance');;
    Route::get('/home/charts/revenue/{year}', [HomeController::class, 'revenuePerMonth'])->middleware('permission:purchases')->name('charts.revenue');;
    Route::get('/home/charts/top-users', [HomeController::class, 'topUsers'])->middleware('permission:purchases')->name('charts.top-users');;
    Route::get('/home/charts/top-cities', [HomeController::class, 'topCities'])->middleware('permission:purchases')->name('charts.top-cities');;

    Route::get('revenue', [PurchaseController::class, 'index'])->middleware('permission:purchases')->name('revenue');

    Route::resource('cities', CityController::class)->middleware('permission:cities');

    Route::resource('gyms', GymController::class)->middleware('permission:gyms');

    Route::resource('city_managers', CityManagerController::class)->middleware('permission:city_managers');

    Route::resource('gym_managers', GymManagerController::class)->middleware('permission:gym_managers');
    Route::patch('/gym_managers/ban/{gymManager}', [GymManagerController::class, 'ban'])->name('gym_managers.ban')->middleware('permission:gym_managers');


    Route::resource('general_managers', GeneralManagerController::class)->middleware('permission:general_managers');

    Route::resource('coaches', CoachController::class)->middleware('permission:coaches');;

    Route::resource('users', UserController::class)->middleware('permission:users');

    Route::resource('sessions', SessionsController::class)->middleware('permission:sessions');

    Route::resource('attendance', AttendanceController::class)->only(['index'])->middleware('permission:attendance');

    Route::resource('packages', PackagesController::class)->middleware('permission:packages');

    Route::get('purchases/finish/{status}',[PurchaseController::class,'pay'])->name('payment')->middleware('permission:purchases');

    Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store'])->middleware('permission:purchases');

    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [ManagerController::class,'index'])->name('index');
        Route::put('/update-basic', [ManagerController::class,'updateBasicInformation'])->name('update-basic');
        Route::put('/update-password', [ManagerController::class,'updatePassword'])->name('update-password');
    });

});

Auth::routes(['register' => false]);
