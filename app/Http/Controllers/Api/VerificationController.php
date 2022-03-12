<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\WelcomeMember;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public  function verify(EmailVerificationRequest $request, $userId)
    {
        $request->fulfill();

        $newUser = User::where('id', $userId)->first();

        // Notification::send($newUser,new WelcomeMailNotification($newUser));
        Mail::to($newUser)->send(new WelcomeMember($newUser));

        return response()
            ->json(['message' => 'Verified Successfully']);
    }

    public function resendVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return response()
            ->json(['message' => 'Verification link sent!']);
    }
}
