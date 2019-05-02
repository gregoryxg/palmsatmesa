@extends('layouts._header')

@section('content')
    <h3>{{$project->title}}</h3>
    <div> {{$project->description}}</div>
    <p><a href="/projects/{{$project->id}}/edit">Edit</a></p>
@endsection