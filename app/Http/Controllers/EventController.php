<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\Event;
use App\User;

class EventController extends Controller
{
    public function index(User $user)
    {
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
        return view('events.createevent');
    }

    public function store(Request $request)
    {
        $event= new Event();
        $event->title=$request->get('title');
        $event->start_date=$request->get('startdate');
        $event->end_date=$request->get('enddate');
        $event->save();
        return redirect('event')->with('success', 'Event has been added');
    }
}
