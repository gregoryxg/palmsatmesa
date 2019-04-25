@extends('layouts.header')

@section('content')
    <h3>{{$project->title}}</h3>
    <div> {{$project->description}}</div>
    <p><a href="/projects/{{$project->id}}/edit">Edit</a></p>
    <p><a href="/tasks/{{$project->id}}/create">Edit</a></p>
@endsection