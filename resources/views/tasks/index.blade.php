@extends('layouts._header')

@section('title', 'Projects')

@section('content')
    <h1>Tasks</h1>
    @foreach ($project->tasks as $task)
        <li><a href="/tasks/{{$task->id}}">{{$task->description}}<a></li>
        <br>
    @endforeach
@endsection