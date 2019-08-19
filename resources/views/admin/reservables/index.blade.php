@extends('layouts.master')

@section('title', 'Reservable Areas')

@section('content')
    <div class="container pt-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Active</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timeslots as $i=>$timeslot)
                    <tr class='table-row' data-href="/admin/timeslots/{{ $timeslot->id }}">
                        <th scope="row">{{$timeslot->id}}</th>
                        <td>{{$timeslot->start_time}}</td>
                        <td>{{$timeslot->end_time}}</td>
                        <td>{{$timeslot->active}}</td>
                    </tr>
                @endforeach
            </tbody>            
        </table>
    </div>
@endsection