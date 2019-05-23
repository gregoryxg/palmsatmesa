<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\PasswordReset;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $passwordReset = PasswordReset::where('token', $request->token)->first();

        if(isset($passwordReset) )
        {
            if ($passwordReset->expires_at < date('Y-m-d H:i:s'))
            {
                return redirect('/password/reset')->with(["not_allowed"=>"Your verification token has expired. Please request a new email using the link below."]);
            }

            $user = $passwordReset->user;

            $user->password = bcrypt($request->password);

            $user->save();

            $status = "Your password has been changed. Please login.";

            return redirect('/logout')->with("success", $status);
        }
        else
        {
            return back()->withErrors("not_allowed","Verification token not found. Please login and request a new verification email.");
        }
    }
}
