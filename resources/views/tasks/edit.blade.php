@extends('layouts.header')

@section('content')
    <h1>Edit Project</h1>
    <form method="post" action="/projects/{{ $project->id }}">

        @method('PATCH')
        @csrf

        <div>
            <label>Title</label>

            <div>
                <input type="text" name="title" placeholder="Title" value="{{ $project->title }}" required/>
            </div>

        </div>
        <div>
            <label>Description</label>

            <div>
                <textarea name="description" required>{{ $project->description }}</textarea>
            </div>
        </div>
        <div>
            <div>
                <button type="submit">Update Project</button>
            </div>
        </div>
    </form>
    <br/>
    <form method="post" action="/projects/{{ $project->id }}">

        @method('DELETE')
        @csrf

        <div>
            <div>
                <button type="submit">Delete Project</button>
            </div>
        </div>
    </form>
@endsection