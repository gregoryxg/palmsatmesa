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
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Refund;


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
        $event = Event::where([
            'id' => $id, 
            ['date', '>=' , date('Y-m-d')],
            ['user_id', '=', Auth::id()]
        ])->get();

        if(empty($event[0]))
            return redirect('/')->withErrors (['errors'=>'You do not have permission to access that reservation']);
        
        return view('events.reservation', ['event'=>$event[0]]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id != Auth::id())
            return redirect('/')->withErrors (['errors'=>'You do not have permission to access that reservation']);
        
        $event->fill($request->validate([
            'title' => ['required', 'string', 'max:255'],
            'size' => ['required', 'integer', 'min:1', 'max:'.$event->reservable->guest_limit]
        ]));

        $event->save();

        \Mail::to($event->user->email)->send(new ReservationConfirmation($event));

        return redirect('event/'.$id)->with('success', 'Reservation has been updated successfully');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id != Auth::id())
            return redirect('/')->withErrors (['errors'=>'You do not have permission to access that reservation']);

        $diff = (new \DateTime($event->date . " " . $event->timeslot->start_time))->diff(new \DateTime(date('Y-m-d H:i:s')));

        $hours_diff = ($diff->d * 24) + ($diff->h) + ($diff->i/60) + ($diff->s/60/60);

        //Reservations cannot be cancelled within 48 hours of the start time
        if ($hours_diff < 48)
        {

            return back()->withErrors(['errors'=>'Reservations cannot be deleted within 48 hours of the reservation date']);
        }
        else
        {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            
            $refund = Refund::create([
                'charge' => $event->stripe_charge_id,
                'amount' => $event->reservable->reservation_fee - (($event->reservable->reservation_fee*.029) + 30)
            ]);
            
            $refund = "$" . number_format(($event->reservable->reservation_fee - (($event->reservable->reservation_fee*.029) + 30))/100, 2, '.', ' ');
            
            $event->delete();

            \Mail::to($event->user->email)->send(new ReservationCancellation($event));

            return redirect('reservations')->with('success', "Reservation has been deleted successfully. Your refund of $refund will be processed in 5-10 business days.");
        }

    }

    public function create()
    {
        $user = User::findOrFail(Auth::user()->id);
        
//        //The commented code below would prevent renters from making reservations
//        if ($user->resident_status_id == 2)
//        {
//            return back()->withErrors(['Renters are not authorized to add events to the calendar.']);
//        }

        if (!$user->unit->reservations_allowed)
        {
            return back()->withErrors(['Your unit (' . $user->unit_id . ') is not permitted to add events to the calendar.']);
        }

        if (!$user->account_approved)
        {
            return back()->withErrors(['Your account has not been approved yet.']);
        }

        $locations = Reservable::all(['id', 'description', 'guest_limit', 'reservation_fee']);

        return view('events.create', ['locations'=>$locations, 'user'=>$user]);
    }

    public function store(Request $request)
    {        
        $event = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today', 'before_or_equal:+30 days'],
            'reservable_id' => ['required', 'integer', 'exists:reservables,id'],
            'size' => ['required', 'integer', 'min:1', 'max:'.Reservable::find($request->reservable_id)->guest_limit],
            'timeslot_id' => ['required', 'integer', 'exists:timeslots,id'],
            'agree_to_terms' => ['accepted'],
            'esign_consent' => ['accepted'],
            'stripeToken' => ['required', 'string'],
            'stripeEmail' => ['required', 'string']
        ]);
        
        Stripe::setApiKey(env('STRIPE_SECRET'));        

        $charge = Charge::create([            
            'amount'   => str_replace('.', '', Reservable::find($request->reservable_id)->reservation_fee),
            'currency' => 'usd',
            'description' => Reservable::find($request->reservable_id)->description . " reservation",
            'receipt_email' => $request->stripeEmail,
            'source'  => $request->stripeToken
        ]);
        
        $event['stripe_charge_id'] = $charge->id;
        
        $event['stripe_receipt_url'] = $charge->receipt_url;
        
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
