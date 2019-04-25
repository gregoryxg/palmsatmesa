@extends('layouts.header')

@section('title', 'Projects')

@section('content')
    <h1>Projects</h1>
    @foreach ($projects as $project)
        <li><a href="/projects/{{$project->id}}">{{$project->title}}<a></li>
        <br>
    @endforeach
    <a href="/projects/create">Create a new Project</a>
    <br/>
@endsection