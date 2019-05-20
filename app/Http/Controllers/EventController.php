<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\Event;
use App\User;
use App\Reservable;
use App\Timeslot;
use App\EventType;
use Auth;

class EventController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);

        $events = [];

        $reservable_colors = Reservable::all()->keyBy('id')->toArray();

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
                $timeslot = Timeslot::findOrFail($value->timeslot_id);

                $start_date = date('Y-m-d H:i:s', strtotime($value->date . " " . $timeslot->start_time));

                $end_date = date('Y-m-d H:i:s', strtotime($value->date . " " . $timeslot->end_time));

                $events[] = Calendar::event(
                    Reservable::findOrFail($value->reservable_id)->description,
                    false,
                    $start_date,
                    $end_date,
                    $value->id,
                    // Add color
                    [
                        'backgroundColor' => $reservable_colors[$value->reservable_id]['backgroundColor'],
                        'textColor' => $reservable_colors[$value->reservable_id]['textColor']
                    ]
                );
            }
        }

        $calendar = Calendar::addEvents($events)
            ->setOptions([ //set fullcalendar options
                'timeFormat' => 'h:mm A',
                'minTime' => '06:00:00',
                'maxTime' => '22:00:00',
                'displayEventEnd' => true,
                'eventLimitClick' => 'day'
            ])
            ->setCallbacks([
                'eventRender' => 'function(event, element) {
                    element.popover({
                      animation: true,
                      delay: {show:0, hide:1000},
                      html: true,
                      content: $(element).html(),
                      trigger: "hover"
                      });
                    }'
            ]);

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

        $event = new Event($event);

        $response = $event->verify('Reservation');

        if ($response['status'] == 'errors')
        {
            return back()
                ->withInput(['title'=>$event->title, 'size'=>$event->size])
                ->withErrors(['errors'=>$response['response_msg']]);
        }
        else
        {
            $event->save();

            return redirect('event')->with('success', 'Reservation has been added successfully');
        }


    }
}
