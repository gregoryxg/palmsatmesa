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
            $timeslots = Reservable::findOrFail($id)->timeslots;
            return response()->json(['timeslots'=>$timeslots]);
        }
    }

    public function test()
    {
        $existing_events =  Event::select('timeslot_id')->where(['date'=>'2019-05-30','reservable_id'=>1])->get()->toArray();

        $existing_events = array_map(function($timeslot) {return $timeslot['timeslot_id'];}, $existing_events);

        $timeslots = Reservable::findOrFail(1)->timeslots->whereNotIn('id', $existing_events)->toArray();

        dd($timeslots);


        $timeslots = Reservable::findOrFail(1)->timeslots;

        dd(Event::findOrFail(1)->timeslot('2019-05-30')->id);
    }
}
