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
        @if ($errors->has('failure'))
            <div class="alert alert-danger text-center">
                <span role="alert"><strong>{{ $errors->first('failure') }}</strong></span>
            </div>
        @endif

        <div class="table-responsive table-hover">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col" nowrap>#</th>
                    <th scope="col" nowrap>Subject</th>
                    <th scope="col" nowrap>Ticket Type</th>
                    <th scope="col" nowrap>Created By</th>
                    <th scope="col" nowrap>Assigned To</th>
                    <th scope="col" nowrap>Opened</th>
                    <th scope="col" nowrap>Last Updated</th>
                    <th scope="col" nowrap>Closed</th>
                </tr>
                </thead>
                <tbody>
                    <tr class='table-row' data-href="">
                        <th scope="row">{{ $ticket->id }}</th>
                        <th scope="row">{{ $ticket->subject }}</th>
                        <th scope="row">{{ $ticket->ticket_type->description }}</th>
                        <th scope="row">{{ $ticket->users()->first() ? ($ticket->users()->first()->first_name . " " . $ticket->users()->first()->last_name) : "" }}</th>
                        <th scope="row">@if(isset($ticket->assigned_to_id))
                                            {{$ticket->assigned_to->first_name . " " . $ticket->assigned_to->last_name}}
                                        @else
                                            @if ($ticket->ticket_type->committee->users()->where(['user_id'=>Auth::id()])->get()->first() !== null)
                                                <form action="/committeeticket/{{$ticket->id}}/assign" method="post">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{Auth::id()}}"/>
                                                    <button onclick="return confirm('Are you sure you want to assign yourself to this ticket?')" class="btn btn-info">Assign</button>
                                                </form>
                                            @else
                                                unassigned
                                            @endif
                                        @endif
                        <th scope="row" nowrap>{{ $ticket->created_at ? date("n/d/Y g:i A", strtotime($ticket->created_at)) : "N/A" }}</th>
                        <th scope="row" nowrap>{{ $ticket->updated_at ? date("n/d/Y g:i A", strtotime($ticket->updated_at)) : "N/A" }}</th>
                        <th scope="row" nowrap>{!! $ticket->completed_at ? date("n/d/Y g:i A", strtotime($ticket->completed_at)) : "<a href='/ticket/$ticket->id/close'><button onclick=\"return confirm('Are you sure you want to close this ticket?')\" class='btn btn-secondary'>Close Ticket</button></a>" !!}</th>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive table-hover">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col" nowrap>Original Description</th>
                </tr>
                </thead>
                <tbody>
                    <tr class='table-row' data-href="">
                        <th scope="row">{{ $ticket->body }}</th>
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
                        <th scope="row" nowrap>{{ date("n/d/Y g:i A", strtotime($comment->created_at)) }}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if (is_null($ticket->completed_at))
        <form method="post" action="/ticketComment">
            @csrf
            <input type="hidden" value="{{ $ticket->id }}" name="ticket_id"/>
            <div class="form-group required">
                <label for="comment" class="control-label">Add Comment</label>
                <textarea name="comment" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" rows="5" required>{{ old('comment') }}</textarea>
                @if ($errors->has('comment'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('comment') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group text-right">
                <button onclick="return confirm('Are you sure you want to post this comment?')" id='submit_button' type="submit" class="btn btn-primary">Reply</button>
            </div>
        </form>
        @endif

    </div>

@endsection
