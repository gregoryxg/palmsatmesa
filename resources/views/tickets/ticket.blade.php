@extends('layouts.master')

@section('title', 'Ticket')

@section('active_support', 'active')

@section('active_tickets', 'active')

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
                    <th scope="col" nowrap>Subject</th>
                    <th scope="col" nowrap>Description</th>
                    <th scope="col" nowrap>Ticket Type</th>
                    <th scope="col" nowrap>Assigned To</th>
                    <th scope="col" nowrap>Opened</th>
                    <th scope="col" nowrap>Last Updated</th>
                </tr>
                </thead>
                <tbody>
                    <tr class='table-row' data-href="">
                        <th scope="row">{{ $ticket->subject }}</th>
                        <th scope="row">{{ $ticket->body }}</th>
                        <th scope="row">{{ $ticket->ticket_type->description }}</th>
                        <th scope="row">{{ $ticket->assigned_to_id ? ($ticket->assigned_to->first_name . " " . $ticket->assigned_to->last_name) : "unassigned" }}</th>
                        <th scope="row">{{ $ticket->created_at ?? "N/A" }}</th>
                        <th scope="row">{{ $ticket->updated_at ?? "N/A" }}</th>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive table-striped table-hover">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col" nowrap>Comment</th>
                    <th scope="col" nowrap>By</th>
                    <th scope="col" nowrap>Posted</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($comments as $comment)
                    <tr class='table-row' data-href="">
                        <th scope="row">{{ $comment->comment }}</th>
                        <th scope="row">{{ $comment->user->first_name . " " . $comment->user->last_name }}</th>
                        <th scope="row">{{ $comment->created_at }}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        
    </div>

@endsection
