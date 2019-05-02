@extends('layouts._header')

@section('content')
    <h1>Edit Task</h1>
    <form method="post" action="/tasks/{{ $task->id }}">

        @method('PATCH')
        @csrf

        <div>
            <label>Complete</label>

            <div>
                <input type="checkbox" name="complete" {{ $task->complete ? "checked" : "" }}/>
            </div>

        </div>
        <div>
            <label>Description</label>

            <div>
                <textarea name="description" required>{{ $task->description }}</textarea>
            </div>
        </div>
        <div>
            <div>
                <button type="submit">Update Task</button>
            </div>
        </div>
    </form>
    <br/>
    <form method="post" action="/tasks/{{ $task->id }}">

        @method('DELETE')
        @csrf

        <div>
            <div>
                <button type="submit">Delete Task</button>
            </div>
        </div>
    </form>
@endsection