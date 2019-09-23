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
//use Stripe\Charge;
use Stripe\Refund;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;


class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
                    " - " . $value->size . " guests at " . Reservable::findOrFail($value->reservable_id)->description
                        . " by " . $value->user->first_name . " " . $value->user->last_name . " (Unit " . $value->user->unit->id . ")",
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
        if ($hours_diff < 168)
        {
            return back()->withErrors(['errors'=>'Reservations cannot be deleted within 7 days of the reservation date']);
        }
        else
        {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $refund = Refund::create([
                'charge' => $event->stripe_charge_id,
                'amount' => ($event->reservation_fee + $event->security_deposit) - (($event->reservation_fee*.029) + ($event->security_deposit*.029) + 30)
            ]);

            $refund = "$" . number_format((($event->reservation_fee + $event->security_deposit) - (($event->reservation_fee*.029) + ($event->security_deposit*.029) + 30))/100, 2, '.', ' ');

            $event->delete();

            \Mail::to($event->user->email)->send(new ReservationCancellation($event));

            return redirect('reservations')->with('success', "Reservation has been deleted successfully. Your refund of $refund will be processed in 5-10 business days.");
        }

    }

    public function create()
    {
        $eventParameters = Event::getParameters();

        $eligibility = Event::checkReservationEligibility($eventParameters);

        if (!empty($eligibility['errors']))
            return redirect('/reservations')->withErrors($eligibility);

        return view('events.create', $eligibility);
    }

    public function validateEvent(Request $request)
    {
        $event = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:'.date('Y-m-d', strtotime("+7 days")), 'before_or_equal:'.date('Y-m-d', strtotime("+60 days"))],
            'reservable_id' => ['required', 'integer', 'exists:reservables,id'],
            'size' => ['required', 'integer', 'min:1', 'max:'.Reservable::find($request->reservable_id)->guest_limit],
            'timeslot_id' => ['required', 'integer', 'exists:timeslots,id'],
            'agree_to_terms' => ['accepted'],
            'esign_consent' => ['accepted']/* ,
            'stripeToken' => ['required', 'string'],
            'stripeEmail' => ['required', 'string'] */
        ]);

        if (Auth()->user()->unit->events_in_date_range(0,29)->count() >= 1 && strtotime($event['date']) <= strtotime(date('Y-m-d', strtotime("+29 days"))))
        {
            return back()->withInput(['title'=>$event['title'], 'size'=>$event['size']])->withErrors(['errors'=>'Your unit already has 1 scheduled reservation in the next 30 days.']);
        }
        else if (Auth()->user()->unit->events_from_today->count() >= 2)
        {
            return back()->withInput(['title'=>$event['title'], 'size'=>$event['size']])->withErrors(['errors'=>'Your unit already has 2 scheduled reservations in the next 60 days.']);
        }
        else if (Event::where(['date'=>$event['date'], 'reservable_id'=>$event['reservable_id'], 'timeslot_id'=>$event['timeslot_id']])->get()->count())
        {
            return back()->withInput(['title'=>$event['title'], 'size'=>$event['size']])->withErrors(['errors'=>'That area and timeslot are already booked. Please choose another.']);
        }

        session(['event'=>$event]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $reservable = Reservable::find($request->reservable_id);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'payment_intent_data' => ['capture_method'=>'manual'],
            'line_items' => [[
                'name' => $reservable->description . " reservation",
                'description' => 'Guest Limit: '. $reservable->guest_limit,
                'images' => ["https://palmsatmesa.s3-us-west-1.amazonaws.com/public/reservable_images/$reservable->id.jpg"],
                'amount' => str_replace('.', '', $reservable->reservation_fee + $reservable->security_deposit),
                'currency' => 'usd',
                'quantity' => 1,
            ]],
            'success_url' => 'http://localhost:91/confirmEvent/{CHECKOUT_SESSION_ID}',
            'cancel_url' => 'http://localhost:91/confirmEvent',
        ]);

        /* $charge = Charge::create([
            'amount'   => str_replace('.', '', $reservable->reservation_fee + $reservable->security_deposit),
            'currency' => 'usd',
            'description' => $reservable->description . " reservation",
            'receipt_email' => $request->stripeEmail,
            'source'  => $request->stripeToken
        ]); */

        return redirect('/checkout')->with(['stripe_session_id'=>$session->id]);
    }

    public function checkout()
    {
        return view('checkout.index', ['stripe_session_id'=>session('stripe_session_id')]);
    }

    public function confirmEvent($id)
    {
        $event = session('event');

        $event['stripe_charge_id'] = $charge->id;

        $event['stripe_receipt_url'] = $charge->receipt_url;

        $event['reservation_fee'] = $reservable->reservation_fee;

        $event['security_deposit'] = $reservable->security_deposit;

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
