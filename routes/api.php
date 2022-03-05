<?php

use App\Http\Controllers\Api\RegisterationController;
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


Route::post('new',[RegisterationController::class, 'registerNewUser']);

Auth::routes(['verify' => true]);

Route::middleware('auth:sanctum','verified')->group(function(){
    Route::get('/users/{user}',[UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::get('/users/remaining-sessions/{user}',[UserController::class, 'getRemainingSessions']);
    Route::post('/users/remaining-sessions/{user}',[UserController::class, 'setRemainingSession']);


    // Route::get('/posts', [PostController::class, 'index'])->name('post.index');
    // Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
    // Route::get('/posts/{post}', [PostController::class, 'show'])->name('post.show');
    // Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    // Route::post('/posts',[PostController::class, 'store'])->name('posts.store');
    // Route::put('/posts/{post}', [PostController::class, 'update'])->name('post.update');
    // Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    // Route::get('/users', [UserController::class, 'index'])->name('user.index');
    
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
        'remember_token'=> $userToken
                ]);
    
    return $userToken;
});