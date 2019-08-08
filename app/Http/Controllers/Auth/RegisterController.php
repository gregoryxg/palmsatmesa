<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\ResidentStatus;
use App\VerifyUser;
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
    public function showRegistrationForm()
    {
        $resident_status = ResidentStatus::all();

        return view("auth.register", ['resident_status'=>$resident_status]);
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'unit_id' => ['required', 'integer', 'max:1400'],
            'gate_code' => ['required', 'integer'],
            'resident_status_id' => ['required', 'integer'],
            'profile_picture' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
            'mobile_phone' => ['required', 'string', 'max:255'],
            'home_phone' => ['max:255'],
            'work_phone' => ['max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data['profile_picture'] = strtolower(User::createThumbnail($data['profile_picture']));

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        $verifyUser = VerifyUser::Create([
            'user_id' => $user->id,
            'token' => sha1(time()),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+24 hours'))
        ]);

        \Mail::to($user->email)->send(new EmailVerification($user));

        return $user;

    }
}
