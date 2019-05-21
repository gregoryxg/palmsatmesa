@extends('layouts.master')

@section('title', 'My Tickets')

@section('active_support', 'active')

@section('active_tickets', 'active')

@section('content')
    <div class="container pt-5">

        @if (\Session::has('success'))
            <div class="alert alert-success text-center">
                <span><strong>{{ \Session::get('success') }}</strong></span>
            </div>
        @endif

        <div class="table-responsive table-sm table-hover">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Description</th>
                    <th scope="col">TicketType</th>
                    <th scope="col">AssignedTo</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tickets as $i=>$ticket)
                    <tr class='table-row' data-href="/ticket/{{ $ticket->id }}">
                        <th scope="row">{{  ($i+1) }}</th>
                        <th scope="row">{{ $ticket->subject }}</th>
                        <th scope="row">{{ $ticket->body }}</th>
                        <th scope="row">{{ $ticket->ticket_type->description }}</th>
                        <th scope="row">{{ isset($ticket->assigned_to_id) ? ($ticket->assigned_to->first_name . " " . $ticket->assigned_to->last_name) : "unnassigned" }}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
