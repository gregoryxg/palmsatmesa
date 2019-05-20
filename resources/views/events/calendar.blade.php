@extends('layouts.master')

@section('title', 'Calendar')

@section('active_events', 'active')

@section('active_calendar', 'active')

@section('content')

    <div class="container pt-5">
        <div class="panel panel-default">
            @if (Auth::user()->resident_status->add_to_calendar)
                <div class="panel-heading pb-2">
                    <a href="/event/create"><button class="btn btn-outline-primary"><h2><i class="fas fa-plus-square"></i> New Reservation</h2></button></a>
                </div>
            @endif
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <span><strong>{{ \Session::get('success') }}</strong></span>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert-danger">
                    <span role="alert"><strong>{{ $errors->first() }}</strong></span>
                </div>
            @endif
            <div class="panel-body" >
                {!! $calendar->calendar() !!}
            </div>
        </div>
    </div>
    @section('page_js')
        <script src="{{ asset('js/moment.min.js') }}"></script>
        <script src="{{ asset('js/fullcalendar.min.js') }}"></script>
        {!! $calendar->script() !!}
    @endsection
@endsection