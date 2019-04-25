@extends('layouts.header')

@section('title', 'Create Task')

@section('content')
    <h1>Create a new Task</h1>
    <form method="post" action="/tasks">
        {{csrf_field()}}
        <div>
            <input type="int" name="project_id" placeholder="Project ID" value="{{old('project_id"')}}" required/>
        </div>
        <div>
            <textarea name="description" placeholder="Task Description" required>{{old('description')}}</textarea>
        </div>
        <div>
            <input type="checkbox" name="completed" placeholder="Completed" value="{{old('completed"')}}"/>
        </div>
        <div>
            <button type="submit">Create Task</button>
        </div>

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
