<?php

use App\Http\Controllers\Api\RegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VerificationController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('new',[RegistrationController::class, 'registerNewUser']);

Auth::routes(['verify' => true]);

Route::middleware('auth:sanctum','verified')->group(function(){
    Route::get('/users/',[UserController::class, 'show']);
    Route::put('/users/', [UserController::class, 'update']);
    Route::get('/users/remaining-sessions/',[UserController::class, 'getSessionsInfo']);
    Route::post('/users/training-sessions/{id}/attend',[UserController::class, 'attend']);
    Route::get('/users/history', [UserController::class, 'getHistory']);

    });


//==============Email Verification Routes======================
 
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify']
    )->middleware(['signed','auth:sanctum'])->name('verification.verify');

Route::post('/email/verification-notification', [VerificationController::class, 'resendVerification']
    )->middleware(['auth', 'throttle:6,1','auth:sanctum'])->name('verification.send');

//==============Token Generator (Sanctum)======================

Route::post('/token', function (Request $request) { //sanctum token generator
    
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
    
    $user = User::where('email', $request->email)->first();

    
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    
    $userToken = $user->createToken($request->device_name)->plainTextToken;

    User::where('id', $user->id)->update([
        'last_login' => Carbon::now(),
                ]);
    
    return $userToken;
});