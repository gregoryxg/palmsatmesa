<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Auth;

class CommitteeTicketController extends Controller
{
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

    }

    public function assigned()
    {

    }

    public function closed()
    {

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
