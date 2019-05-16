<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\Event;
use App\User;
use App\Reservable;
use Auth;

class EventController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);

        $events = [];

        if ($user->board_member === true || $user->administrator === true) //Board member / Administrator events
        {
            $data = Event::all();
        }
        else if ($user->id == 1) //Homeowner events
        {
            $data = Event::all();
        }
        else //HOA Events (lessee view)
        {
            $data = Event::all();
        }

        if($data->count())
        {
            foreach ($data as $key => $value)
            {
                $events[] = Calendar::event(
                    $value->title,
                    true,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date.'+1 day'),
                    null,
                    // Add color
                    [
                        'color' => '#000000',
                        'textColor' => '#008000',
                    ]
                );
            }
        }

        $calendar = Calendar::addEvents($events);

        return view('events.calendar', compact('calendar'));
    }

    public function create()
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($user->resident_status_id == 2)
        {
            return back()->withErrors(['Lessees are not authorized to add events to the calendar.']);
        }

        if (!$user->unit->reservations_allowed)
        {
            return back()->withErrors(['Your unit (' . $user->unit_id . ') is not permitted to add events to the calendar.']);
        }

        if (!$user->account_approved)
        {
            return back()->withErrors(['Your account has not been approved yet.']);
        }

        $locations = Reservable::all(['id', 'description']);

        $timeslots = [];

        foreach ($locations as $location)
        {
            $timeslots[$location->id] = $location->timeslots;
        }

        return view('events.create', ['locations'=>$locations, 'timeslots'=>$timeslots]);
    }

    public function store(Request $request)
    {
        $event = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'size' => ['required', 'integer', 'min:1', 'max:30'],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today', 'before_or_equal:+60 days']
        ]);

        dd($request->all());

        $client_ip = Request()->ip();

        dd($client_ip);

        $event= new Event();
        $event->title=$request->get('title');
        $event->start_date=$request->get('startdate');
        $event->end_date=$request->get('enddate');
        $event->save();
        return redirect('event')->with('success', 'Event has been added');
    }
}
