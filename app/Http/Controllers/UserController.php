<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Users are created via the registration controller
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('user.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('user.edit', ['user' => User::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => ['max:255'],
            'last_name' => ['max:255'],
            'profile_picture' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
            'mobile_phone' => ['string', 'regex:/\(\d{3}\) \d{3}-\d{4}/'],
            'home_phone' => ['nullable', 'string', 'regex:/\(\d{3}\) \d{3}-\d{4}/'],
            'work_phone' => ['nullable', 'string', 'regex:/\(\d{3}\) \d{3}-\d{4}/']
        ]);

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

        return redirect("/user/" . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
