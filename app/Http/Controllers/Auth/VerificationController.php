<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\VerifyUser;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'verifyEmail', 'resend');
    }

    public function resend($id)
    {

        $verifyUser = VerifyUser::where(['user_id'=>$id])->first();

        $verifyUser->fill([
            'token' => sha1(time()),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+24 hours'))
        ]);

        $verifyUser->save();

        \Mail::to($verifyUser->user->email)->send(new EmailVerification($verifyUser->user));

        return back()->with('resent',true);
    }

    public function verifyEmail($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();

        if(isset($verifyUser) )
        {
            $user = $verifyUser->user;

            if(is_null($user->email_verified_at))
            {
                if ($verifyUser->expires_at < date('Y-m-d H:i:s'))
                {
                    return redirect('/email/verify')->withErrors(["not_allowed"=>"Your verification token has expired. Please request a new email using the link below."]);
                }

                $verifyUser->user->email_verified_at = date('Y-m-d H:i:s');

                $verifyUser->user->save();

                $status = "Your e-mail is verified. Welcome.";
            }
            else
            {
                $status = "Your e-mail is already verified.";
            }

            return redirect('/')->with("success", $status);
        }
        else
        {
            return redirect('/logout')->with("not_allowed","Verification token not found. Please login and request a new verification email.");
        }
    }
}
