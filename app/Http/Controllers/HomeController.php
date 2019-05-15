<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        //Ensures account is active after successful login
        if (!$user->active)
        {
            Auth::logout();
            return redirect('/login')->withErrors(["not_allowed"=>"Your account has been disabled. Please contact support for assistance."]);
        }

        //Ensures user's password has not expired (expires every 3 months)
        if (date('Y-m-d H:i:s', strtotime($user->password_expires_at)) < date('Y-m-d H:i:s'))
        {
            Auth::logout();
            return redirect('/login')->withErrors(["not_allowed"=>"Your password has expired. Use the 'Forgot Your password' link to reset it."]);
        }

        return view('index');
    }
}
