<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservable;
use App\Event;
use App\User;

class ReservableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function timeslots(Request $request, $id)
    {
        if ($request->ajax()) {

            $existing_unit_events = User::findOrFail($request->user_id)->unit->events()->where([['date', '=', date('Y-m-d', strtotime($request->date))]])->get()->count();

            if ($existing_unit_events > 0) {
                return response()->json(['timeslots' => []]);
            }

            $existing_events = Event::select('timeslot_id')->where(['date' => $request->date, 'reservable_id' => $id])->get()->toArray();

            $existing_events = array_map(function ($timeslot) {
                return $timeslot['timeslot_id'];
            }, $existing_events);

            $timeslots = Reservable::findOrFail($id)->timeslots->whereNotIn('id', $existing_events)->toArray();

            return response()->json(['timeslots' => $timeslots]);
        }
    }

    public function locations(Request $request)
    {
        if ($request->ajax()) {

            $existing_unit_events = User::findOrFail($request->user_id)->unit->events()
                    ->where([
                            ['date', '=', date('Y-m-d', strtotime($request->date))], 
                            ])
                    ->get()
                    ->count();

            if ($existing_unit_events > 0) {
                return response()->json(['result'=>1]);
            }
            else
            {
                return response()->json(['result'=>0]);
            }
        }
    }
}
