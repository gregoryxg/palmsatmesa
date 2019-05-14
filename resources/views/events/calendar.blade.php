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
            <div class="panel-heading pb-2">
                <a href="/event/create"><button class="btn btn-outline-primary"><h2><i class="fas fa-plus-square"></i> Add to Calendar</h2></button></a>
            </div>
            <div class="alert-danger">
                @if ($errors->any())
                    <span role="alert"><strong>{{ $errors->first() }}</strong></span>
                @endif
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