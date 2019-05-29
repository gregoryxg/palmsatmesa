<?php

namespace App\Http\Controllers;

use App\Mail\ReservationConfirmation;
use App\Mail\ReservationCancellation;
use Illuminate\Http\Request;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\Event;
use App\User;
use App\Reservable;
use App\Timeslot;
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

    public function reservations()
    {
        //Lists user's reservations
        $events = Event::where(['user_id' => Auth::user()->id, ['date', '>=' , date('Y-m-d')]])->orderBy('date')->orderBy('id')->get();

        return view('events.reservations', ['events'=>$events]);
    }

    public function show($id)
    {
        $event = Event::where(['id' => $id, ['date', '>=' , date('Y-m-d')]])->get();

        return view('events.reservation', ['event'=>$event[0]]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $event->fill($request->validate([
            'title' => ['required', 'string', 'max:255'],
            'size' => ['required', 'integer', 'min:1', 'max:30']
        ]));

        $event->save();

        \Mail::to($event->user->email)->send(new ReservationConfirmation($event));

        return redirect('event/'.$id)->with('success', 'Reservation has been updated successfully');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        $diff = (new \DateTime($event->date . " " . $event->timeslot->start_time))->diff(new \DateTime(date('Y-m-d H:i:s')));

        $hours_diff = ($diff->d * 24) + ($diff->h) + ($diff->i/60) + ($diff->s/60/60);

        //Reservations cannot be cancelled within 48 hours
        if ($hours_diff < 48)
        {

            return back()->withErrors(['errors'=>'Reservations cannot be deleted within 48 hours of the reservation date']);
        }
        else
        {
            $event->delete();

            \Mail::to($event->user->email)->send(new ReservationCancellation($event));

            return redirect('reservations')->with('success', 'Reservation has been deleted successfully');
        }

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

        return view('events.create', ['locations'=>$locations, 'user'=>$user]);
    }

    public function store(Request $request)
    {
        $event = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'size' => ['required', 'integer', 'min:1', 'max:30'],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today', 'before_or_equal:+30 days'],
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

            \Mail::to($event->user->email)->send(new ReservationConfirmation($event));

            return redirect('event')->with('success', 'Reservation has been added successfully');
        }


    }
}
