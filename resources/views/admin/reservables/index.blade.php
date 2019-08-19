@extends('layouts.master')

@section('title', 'Reservable Areas')

@section('content')
    <div class="container pt-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Description</th>
                    <th scope="col">Guest Limit</th>
                    <th scope="col">Reservation Fee</th>
                    <th scope="col">Security Deposit</th>
                    <th scope="col">Calendar Background Color</th>
                    <th scope="col">Calendar Text Color</th>
                    <th scope="col">Active</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservables as $i=>$reservable)
                    <tr class='table-row' data-href="/admin/reservables/{{ $reservable->id }}">
                        <th scope="row">{{$reservable->id}}</th>
                        <td>{{$reservable->description}}</td>
                        <td>{{$reservable->guest_limit}}</td>
                        <td>${{number_format($reservable->reservation_fee/100, 2)}}</td>
                        <td>${{number_format($reservable->security_deposit/100, 2)}}</td>
                        <td style="color:{{$reservable->backgroundColor}};"><b>{{$reservable->backgroundColor}}</b></td>
                        <td style="background-color:{{$reservable->backgroundColor}};color:{{$reservable->textColor}}"><b>{{$reservable->textColor}}</b></td>
                        <td>{{$reservable->active}}</td>
                    </tr>
                @endforeach
            </tbody>            
        </table>
    </div>
@endsection