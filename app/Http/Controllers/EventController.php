<?php

namespace App\Http\Controllers;

use App\Mail\ReservationConfirmation;
use App\Mail\ReservationCancellation;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateEvent;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\Event;
use App\User;
use App\Reservable;
use App\EventType;
use Auth;
use Stripe\Stripe;
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
            $data = Event::all()->where('cancelled_at', '=', null);
        }
        else if ($user->id == 1) //Homeowner events
        {
            $data = Event::all()->where('cancelled_at', '=', null);
        }
        else //HOA Events (lessee view)
        {
            $data = Event::all()->where('cancelled_at', '=', null);
        }

        if($data->count())
        {
            foreach ($data as $key => $value)
            {
                $start_date = date('Y-m-d H:i:s', strtotime($value->date . " " . $value->start_time));

                $end_date = date('Y-m-d H:i:s', strtotime($value->date . " " . $value->end_time));

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
        $events = Event::where([
            'user_id' => Auth::user()->id,
            ['date', '>=' , date('Y-m-d')],
            ['cancelled_at', '=', null]
        ])->orderBy('date')->orderBy('id')->get();

        return view('events.reservations', ['events'=>$events]);
    }

    public function show($id)
    {
        $event = Event::where([
            'id' => $id,
            ['date', '>=' , date('Y-m-d')],
            ['user_id', '=', Auth::id()],
            ['cancelled_at', '=', null]
        ])->get();

        if(empty($event[0]))
            return redirect('/reservations')->withErrors (['errors'=>'You do not have permission to access that reservation']);

        return view('events.reservation', ['event'=>$event[0], 'locations'=>Reservable::all()]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id != Auth::id() || !is_null($event->cancelled_at))
            return redirect('/reservations')->withErrors (['errors'=>'You do not have permission to access that reservation']);

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

        if ($event->user_id != Auth::id() || !is_null($event->cancelled_at))
            return redirect('/reservations')->withErrors (['errors'=>'You do not have permission to access that reservation']);

        $start_time = strtotime($event->date . " " . $event->start_time);

        $diff = $start_time - strtotime(date('Y-m-d H:i:s'));

        $hours_diff = $diff / (60 * 60);

        //Reservations cannot be cancelled within configured hours of the start time
        if ($hours_diff < config('event.noCancellationWindow')/60)
        {
            return back()->withErrors(['errors'=>'Reservations cannot be deleted within ' . config('event.noCancellationWindow')/60 . ' hours of the start time.']);
        }
        else
        {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $refund = Refund::create([
                'charge' => $event->stripe_charge_id,
                'amount' => ($event->reservation_fee + $event->security_deposit) - (($event->reservation_fee*.029) + ($event->security_deposit*.029) + 30)
            ]);

            $refund = "$" . number_format((($event->reservation_fee + $event->security_deposit) - (($event->reservation_fee*.029) + ($event->security_deposit*.029) + 30))/100, 2, '.', ' ');

            $event->fill([
                'cancelled_by_id'=>Auth::id(),
                'cancelled_at'=>date('Y-m-d H:i:s')
            ]);

            $event->save();

            \Mail::to($event->user->email)->send(new ReservationCancellation($event));

            return redirect('/reservations')->with('success', "Reservation has been cancelled successfully. Your refund of $refund will be processed in 5-10 business days.");
        }

    }

    public function create()
    {
        $eventParameters = config('event');

        $eligibility = Event::checkReservationEligibility($eventParameters);

        if (!empty($eligibility['errors']))
            return redirect('/reservations')->withErrors($eligibility);

        return view('events.create', $eligibility);
    }

    public function validateEvent(ValidateEvent $request)
    {
        session(['event'=>$request->all()]);

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
            'success_url' => 'http://gregoryxg.ddns.net:90/confirmEvent/{CHECKOUT_SESSION_ID}',
            'cancel_url' => 'http://gregoryxg.ddns.net:90/confirmEvent',
        ]);

        return redirect('/checkout')->with(['stripe_session_id'=>$session->id]);
    }

    public function checkout()
    {
        return view('checkout.index', ['stripe_session_id'=>session('stripe_session_id')]);
    }

    public function confirmEvent($id)
    {
        $event = Event::make(session('event'));

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::retrieve($id);

        $paymentIntent = PaymentIntent::retrieve($session->payment_intent);

        $validation = $event->confirm();

        if($validation->fails())
        {
            $paymentIntent->cancel();

            return redirect('/event/create')
                ->withErrors($validation)
                ->withInput();
        }

        $paymentIntent->capture();

        $charge = $paymentIntent->charges->data[0];

        $event->fill([
            'start_time'=>date('H:i:s', strtotime($event->start_time)),
            'end_time'=>date('H:i:s', strtotime($event->end_time)),
            'stripe_charge_id'=>$charge->id,
            'stripe_receipt_url'=>$charge->receipt_url,
            'reservation_fee'=>$event->reservable->reservation_fee,
            'security_deposit'=>$event->reservable->security_deposit,
            'user_id'=>Auth::id(),
            'reserved_from_ip_address'=>Request()->ip(),
            'event_type_id'=>EventType::where(['type' => 'Reservation'])->first()->id
        ]);

        $event->save();

        \Mail::to($event->user->email)->send(new ReservationConfirmation($event));

        return redirect('event')->with('success', 'Reservation has been added successfully');
    }
}
