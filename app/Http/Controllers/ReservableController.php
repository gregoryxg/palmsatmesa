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

    /*public function test()
    {
        $existing_events =  Event::select('timeslot_id')->where(['date'=>'2019-05-30','reservable_id'=>3])->get()->toArray();

        $existing_events = array_map(function($timeslot) {return $timeslot['timeslot_id'];}, $existing_events);

        $timeslots = Reservable::findOrFail(1)->timeslots->whereNotIn('id', $existing_events)->toArray();

        var_dump($timeslots);

        $available_timeslots = [];

        foreach ($timeslots as $timeslot)
        {
            array_push($available_timeslots, $timeslot);
        }

        dd($available_timeslots);

    }*/
}
