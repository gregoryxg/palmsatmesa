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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" integrity="sha512-CryKbMe7sjSCDPl18jtJI5DR5jtkUWxPXWaLCst6QjH8wxDexfRJic2WRmRXmstr2Y8SxDDWuBO6CQC6IE4KTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js" integrity="sha512-iusSCweltSRVrjOz+4nxOL9OXh2UA0m8KdjsX8/KUUiJz+TCNzalwE0WE6dYTfHDkXuGuHq3W9YIhDLN7UNB0w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        {!! $calendar->script() !!}
    @endsection
@endsection
