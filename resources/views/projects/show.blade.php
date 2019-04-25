@extends('layouts.header')

@section('content')
    <h3>{{$project->title}}</h3>
    <div> {{$project->description}}</div>
    <p><a href="/projects/{{$project->id}}/edit">Edit</a></p>

    @if($project->tasks->count())
    <div>
        @foreach($project->tasks as $task)
            <li>{{$task->description}}</li>
        @endforeach
    </div>
    @endif

    <form method="post" action="/tasks">
        @csrf
        <input type="hidden" name="project_id" value="{{$project->id}}" required/>
        <textarea name="description" required>Task Description</textarea>
        <button type="submit">Create Task</button>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>

@endsection