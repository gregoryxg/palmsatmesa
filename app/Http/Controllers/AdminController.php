<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Timeslot;
use App\Reservable;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $new_users = User::where(['account_approved'=>false, ['email_verified_at', '<>', null]])->get();

        return view('admin.dashboard', ['new_users'=>$new_users]);
    }

    public function searchUser()
    {
        return view('admin.searchUsers');
    }

    public function userResults(Request $request)
    {
        $users = User::lookupUsers($request->search_by, $request->search_val);

        if($users->isEmpty())
            return back()->withErrors(['errors'=>"No user found with the following search parameters: $request->search_by: $request->search_val"]);
        dd();
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

    public function reservables()
    {
        $reservables = Reservable::all();

        return view('admin.reservables.index', ['reservables'=>$reservables]);
    }

    public function reservable($id)
    {
        $reservable = Reservable::findOrFail($id);

        return view('admin.reservables.show', ['reservable'=>$reservable]);
    }

    public function timeslots()
    {
        $timeslots = Timeslot::all();

        return view('admin.timeslots.index', ['timeslots'=>$timeslots]);
    }

    public function timeslot($id)
    {
        $timeslot = Timeslot::findOrFail($id);

        return view ('admin.timeslots.show', ['timeslot'=>$timeslot]);
    }

    public function updateTimeslot(Request $request, $id)
    {
        $validated = $request->validate([
            'start_time' => ['date_multi_format:"H:i:s","H:i"', 'required'],
            'end_time' => ['date_multi_format:"H:i:s","H:i"', 'after:start_time', 'required'],
            'active'=>[''],
        ]);

        if (!$request->has('active'))
            $validated['active'] = false;

        $duplicate = Timeslot::where(['start_time'=>$validated['start_time'], 'end_time'=>$validated['end_time']])->get();

        //Ensures the time slot doesn't already exist under a different ID
        if (!empty($duplicate) && !empty($duplicate->first()->id) && $duplicate->first()->id != $id)
            return back()->withErrors(['errors'=>'That timeslot already exists. Use a different start and/or end time']);

        $timeslot = Timeslot::findOrFail($id);

        $timeslot->fill($validated);

        $timeslot->save();

        //Updates any ReservableTimeslot entries as active/inactive when a timeslot is activated/deactivated
        foreach ($timeslot->reservables as $reservable)
        {
            $timeslot->reservables()->updateExistingPivot($reservable->id, ['active'=>$timeslot->active]);
        }

        return redirect('/admin/timeslots/'.$id)->with(['success'=>'Timeslot updated successfully']);
    }
}
