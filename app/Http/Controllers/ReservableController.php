<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservable;

class ReservableController extends Controller
{
    public function timeslots(Request $request, $id)
    {
        if($request->ajax()) {
            $timeslots = Reservable::findOrFail($id)->timeslots;
            return response()->json(['timeslots'=>$timeslots]);
        }
    }
}
