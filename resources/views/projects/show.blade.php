@extends('layouts.app')

@section('title', 'Project Tasks')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h2 class="mb-4">Tasks for Project: {{ $project->name }}</h2>

        <!-- Flash message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Task form -->
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <div class="mb-3">
                <label for="title" class="form-label">Task Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Enter task title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Task Description</label>
                <textarea name="description" class="form-control" id="description" rows="3" placeholder="Enter task description"></textarea>
            </div>
            <div class="mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control" id="due_date">
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>

        <hr>

        <!-- Task list -->
        <h3 class="mt-5">Tasks in {{ $project->name }}</h3>
        <ul class="list-group mb-4">
            @forelse ($project->tasks as $task)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5>{{ $task->title }}</h5>
                        <p>{{ $task->description }}</p>
                        <small>Due on: {{ $task->due_date }}</small>
                    </div>
                    <div>
                        <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Mark as Complete</button>
                        </form>
                        <form action="{{ route('tasks.delete', $task->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="list-group-item">No tasks in this project.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
