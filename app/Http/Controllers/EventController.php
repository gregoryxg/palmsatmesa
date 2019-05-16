<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
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
            'date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today', 'before_or_equal:+60 days'],
            'reservable_id' => ['required', 'integer', 'exists:reservables,id'],
            'timeslot_id' => ['required', 'integer', 'exists:timeslots,id'],
            'agree_to_terms' => ['accepted'],
            'esign_consent' => ['accepted']
        ]);

        $event['user_id'] = Auth::id();

        $event['reserved_from_ip_address'] = Request()->ip();

        $event = new Event($event);

        $checkExisting = Event::where(['date'=>$event->date, 'reservable_id'=>$event->reservable_id, 'timeslot_id'=>$event->timeslot_id])->get();
//dd($event);
        if(count($checkExisting) > 0)
        {
            return back()->withInput(['title'=>$event->title, 'size'=>$event->size])->withErrors(['exists'=>'A reservation for that location at that date and time already exists.']);
        }
        else
        {
            $event->save();

            return redirect('event')->with('success', 'Reservation has been added successfully');
        }

    }
}
