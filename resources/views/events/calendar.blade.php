@extends('layouts.master')

@section('title', 'Calendar')

@section('active_events', 'nav-item active')

@section('content')

    <div class="container pt-5">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div><br />
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Laravel Full Calendar Tutorial</h2>
            </div>
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