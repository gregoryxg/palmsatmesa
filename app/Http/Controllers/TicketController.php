<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTicket;
use App\Ticket;
use App\TicketComment;
use App\TicketType;
use Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Auth::user()->open_tickets;

        return view('tickets.tickets', ['tickets'=>$tickets]);
    }

    public function closed()
    {
        $tickets = Auth::user()->closed_tickets;

        return view('tickets.tickets', ['tickets'=>$tickets]);
    }

    public function close($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->close();

        return back()->with(['success'=>"Ticket # $id has been closed"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ticket_types = TicketType::all();

        return view('tickets.create', ['ticket_types'=>$ticket_types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicket $request)
    {
        $ticket = new Ticket($request->validated());

        $ticket->save();

        $ticket->users()->attach(Auth::id());



        return back()->with(['success'=>'Your ticket has been submitted. Please allow up to 1 business day for a response, thank you.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);

        $comments = TicketComment::where(['ticket_id'=>$ticket->id])->get();

        return view('tickets.ticket', ['ticket'=>$ticket, 'comments'=>$comments]);
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
