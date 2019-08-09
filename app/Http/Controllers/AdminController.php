<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        $new_users = User::where(['account_approved'=>false])->get();

        return view('admin.dashboard', ['new_users'=>$new_users]);
    }
    
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        
        return view('admin.editUser', ['user'=>$user]);
    }
    
    public function updateUser(Request $request, $id)
    {
        
        $validated = $request->validate([
            'first_name' => ['max:255'],
            'last_name' => ['max:255'],
            'unit_id' => ['required', 'integer', 'max:1400'],
            'gate_code' => ['required', 'integer'],
            'resident_status_id' => ['required', 'integer'],
            'profile_picture' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
            'mobile_phone' => ['max:255'],
            'home_phone' => ['max:255'],
            'work_phone' => ['max:255'],
            'account_approved'=>[''],
            'board_member'=>[''],
            'administrator'=>[''],
            'active'=>['']
        ]);
        
        if (!$request->has('account_approved'))
            $validated['account_approved'] = false;
        
        if (!$request->has('board_member'))
            $validated['board_member'] = false;

        
        if (!$request->has('administrator'))
            $validated['administrator'] = false;

        
        if (!$request->has('active'))
            $validated['active'] = false;


        $user = User::findOrFail($id);

        if (isset($request->email))
        {
            if ($user->email !== $request->email)
                $validated['email'] = $request->validate(['email' => ['required', 'string', 'email', 'max:255', 'unique:users']])['email'];
        }

        if (isset($validated['profile_picture']))
        {
            $validated['profile_picture'] = User::createThumbnail($validated['profile_picture'], $id);
        }

        $user->fill($validated);

        $user->save();

        return redirect("admin/editUser/" . $id);
    }
}
