<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class StripeController extends Controller
{
    public function index()
    {        
        return view ('stripe/payment');
    }
    
    public function charge(Request $request)
    {        
        Stripe::setApiKey(env('STRIPE_SECRET'));        

        $charge = Charge::create([            
            'amount'   => 100,
            'currency' => 'usd',
            'receipt_email' => $request->stripeEmail,
            'source'  => $request->stripeToken
        ]);
        
        dd($charge);
    }
    
    public function refund(Request $request)
    {
        
    }
}
