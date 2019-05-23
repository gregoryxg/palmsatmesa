<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetEmail;
use App\PasswordReset;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $passwordReset = PasswordReset::updateOrCreate(
            ['email'=>$request->email],
            [
                'token' => sha1(time()),
                'expires_at' => date('Y-m-d H:i:s', strtotime('+24 hours'))
            ]
        );

        $user = $passwordReset->user;

        \Mail::to($user->email)->send(new PasswordResetEmail($user));

        return back()->with('status', 'A password reset email has been sent to your account.');
    }
}
