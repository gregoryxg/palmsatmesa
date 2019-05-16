<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservable;
use App\Event;
use App\Timeslot;

class ReservableController extends Controller
{
    public function timeslots(Request $request, $id)
    {
        if($request->ajax()) {

            $existing_events =  Event::select('timeslot_id')->where(['date'=>$request->date,'reservable_id'=>$id])->get()->toArray();

            $existing_events = array_map(function($timeslot) {return $timeslot['timeslot_id'];}, $existing_events);

            $timeslots = Reservable::findOrFail($id)->timeslots->whereNotIn('id', $existing_events)->toArray();

            return response()->json(['timeslots'=>$timeslots]);
        }
    }
}
