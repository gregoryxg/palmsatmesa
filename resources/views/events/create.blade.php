<!-- create.blade.php -->

{{--<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laravel Full Calendar Example</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
</head>
<body>--}}
@extends('layouts.master')

@section('title', 'Create New Event')

@section('active_events', 'nav-item active')

@section('content')
<div class="container pt-5">
    <br/>
    <form method="post" action="/event">
        @csrf
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="Title">Title:</label>
                <input type="text" class="form-control" name="title">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <strong> Start Date : </strong>
                <input class="date form-control"  type="text" id="startdate" name="startdate">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <strong> End Date : </strong>
                <input class="date form-control"  type="text" id="enddate" name="enddate">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-secondary">Add Event</button>
            </div>
        </div>
    </form>
</div>
@endsection
{{--
<script type="text/javascript">
    $('#startdate').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    $('#enddate').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
</script>
</body>
</html>--}}
