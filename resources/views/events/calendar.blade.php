@extends('layouts.master')

@section('title', 'Calendar')

@section('active_events', 'active')

@section('active_calendar', 'active')

@section('content')

    <div class="container pt-5">
        <div class="panel panel-default">
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