@extends('layouts.master')

@section('title', 'My Tickets')

@section('active_support', 'active')

@if(basename(Request::url()) == "closed_ticket")
    @section('active_closed_tickets', 'active')
@else
    @section('active_open_tickets', 'active')
@endif

@section('content')
    <div class="container pt-5">

        @if (\Session::has('success'))
            <div class="alert alert-success text-center">
                <span><strong>{{ \Session::get('success') }}</strong></span>
            </div>
        @endif

        <div class="table-responsive table-hover">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col" nowrap>#</th>
                    <th scope="col" nowrap>Subject</th>
                    <th scope="col" nowrap>Ticket Type</th>
                    <th scope="col" nowrap>Assigned To</th>
                    <th scope="col" nowrap>Opened</th>
                    <th scope="col" nowrap>Last Updated</th>
                    <th scope="col" nowrap>Closed</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tickets as $i=>$ticket)
                    <tr class='table-row' data-href="/ticket/{{ $ticket->id }}">
                        <th scope="row">{{ $ticket->id }}</th>
                        <th scope="row">{{ $ticket->subject }}</th>
                        <th scope="row">{{ $ticket->ticket_type->description }}</th>
                        <th scope="row">{{ $ticket->assigned_to_id ? ($ticket->assigned_to->first_name . " " . $ticket->assigned_to->last_name) : "unassigned" }}</th>
                        <th scope="row" nowrap>{{ $ticket->created_at ? date("n/d/Y g:i A", strtotime($ticket->created_at)) : "N/A" }}</th>
                        <th scope="row" nowrap>{{ $ticket->updated_at ? date("n/d/Y g:i A", strtotime($ticket->updated_at)) : "N/A" }}</th>
                        <th scope="row" nowrap>{{ $ticket->completed_at ? date("n/d/Y g:i A", strtotime($ticket->completed_at)) : "N/A" }}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
