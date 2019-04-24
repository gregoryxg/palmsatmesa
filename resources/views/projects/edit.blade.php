@extends('layouts.header')

@section('content')
    <h1>Edit Project</h1>
    <form method="post" action="/projects/{{ $project->id }}">
        {{method_field('PATCH')}}
        {{csrf_field()}}
        <div>
            <label>Title</label>

            <div>
                <input type="text" name="title" placeholder="Title" value="{{ $project->title }}"/>
            </div>

        </div>
        <div>
            <label>Description</label>

            <div>
                <textarea name="description">{{ $project->description }}</textarea>
            </div>
        </div>
        <div>
            <div>

                <button type="submit">Update Project</button>
            </div>
        </div>
    </form>
@endsection