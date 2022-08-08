<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommitteeTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_committees = Auth::user()->committees()->with('tickets')->get();

        $tickets = [];

        foreach ($user_committees as $committee)
        {
            foreach ($committee->tickets as $ticket)
            {
                if ($ticket->assigned_to_id == null && $ticket->completed_at == null)
                    $tickets[] = $ticket;
            }
        }

        return view('tickets.tickets', ['tickets'=>$tickets]);
    }

    public function assign(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $user = User::findOrFail($request->user_id);

        if($ticket->assign($user->id))
            return back()->with(['success'=>"Ticket # $id has been assigned to " . $user->first_name . " " . $user->last_name]);
        else
            return back()->withErrors(['failure'=>"Could not assign User # $user->id ($user->first_name $user->last_name) to Ticket # $id... submit a ticket to the system administrator with this message."]);

    }

    public function user_assigned()
    {
        $tickets = Ticket::select()->where('assigned_to_id',Auth::id())->get();

        return view('tickets.tickets', ['tickets'=>$tickets]);
    }

    public function assigned()
    {
        $user_committees = Auth::user()->committees()->with('tickets')->get();

        $tickets = [];

        foreach ($user_committees as $committee)
        {
            foreach ($committee->tickets as $ticket)
            {
                if ($ticket->assigned_to_id !== Auth::id() && $ticket->assigned_to_id !== null)
                    $tickets[] = $ticket;
            }
        }

        return view('tickets.tickets', ['tickets'=>$tickets]);
    }

    public function closed()
    {
        $user_committees = Auth::user()->committees()->with('tickets')->orderBy('id','desc')->get();

        $tickets = [];

        foreach ($user_committees as $committee)
        {
            foreach ($committee->tickets as $ticket)
            {
                if ($ticket->completed_at !== null)
                    $tickets[] = $ticket;
            }
        }

        return view('tickets.tickets', ['tickets'=>$tickets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
