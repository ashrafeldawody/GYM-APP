<?php

use App\Http\Controllers\Api\RegisterationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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


Route::post('new',[RegisterationController::class, 'registerNewUser']);

Auth::routes(['verify' => true]);

Route::middleware('auth:sanctum','verified')->group(function(){
    Route::resource('users', UserController::class);
    
    });


//==============Email verification routes======================
 
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return "Verified Successfully";
})->middleware(['signed','auth:sanctum'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) { 
    //resend verification Email route
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1','auth:sanctum'])->name('verification.send');

//==============Token Generator (Sanctum)======================

Route::post('/token', function (Request $request) { //sanctum token generator
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
    
    $user = User::where('email', $request->email)->first();

    //to be added with migration
    // User::where('user_id', $user->id)
    //             ->update(['last_login' => Carbon::now()]);
    
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    
    return $user->createToken($request->device_name)->plainTextToken;
});