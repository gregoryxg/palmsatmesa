@extends('layouts.master')

@section('title', 'New Ticket')

@section('active_support', 'active')

@section('active_new_ticket', 'active')

@section('content')
    <div class="container pt-5">

        @if (\Session::has('success'))
            <div class="alert alert-success text-center">
                <span><strong>{{ \Session::get('success') }}</strong></span>
            </div>
        @endif


    </div>

@endsection
