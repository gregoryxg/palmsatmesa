@extends('layouts.master')

@section('title', 'My Reservations')

@section('active_events', 'active')

@section('active_my_reservations', 'active')

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
                    <th scope="col">Title</th>
                    <th scope="col">Party Size</th>
                    <th scope="col">Location</th>
                    <th scope="col">Date</th>
                    <th scope="col">Timeslot</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($events as $i=>$event)
                <tr class='table-row' data-href="/event/{{ $event->id }}">
                    <th scope="row">{{  ($i+1) }}</th>
                    <th scope="row">{{ $event->title }}</th>
                    <th scope="row">{{ $event->size }}</th>
                    <th scope="row">{{ $event->reservable->description }}</th>
                    <th scope="row">{{ date('m/d/Y', strtotime($event->date)) }}</th>
                    <th scope="row">{{ date('g:i A', strtotime($event->timeslot->start_time)) . " - " . date('h:i A', strtotime($event->timeslot->end_time)) }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
