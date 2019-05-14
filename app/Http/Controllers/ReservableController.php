<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservableController extends Controller
{
    public function timeslots(Request $request, $id)
    {
        if ($request->ajax()) {
            return response()->json([
                'timeslots' => Timeslot::where(1/*'reservable_id', $id*/)->get()
            ]);
        }
    }
}
