@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h2 class="mb-4">My Projects</h2>

        <!-- Flash message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Project form -->
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Project Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter project name">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Project Description</label>
                <textarea name="description" class="form-control" id="description" rows="3" placeholder="Enter project description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Project</button>
        </form>

        <hr>

        <!-- Project list -->
        <h3 class="mt-5">Your Projects</h3>
        <ul class="list-group mb-4">
            @forelse ($projects as $project)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5>{{ $project->name }}</h5>
                        <p>{{ $project->description }}</p>
                        <small>Created on: {{ $project->created_at->format('M d, Y') }}</small>
                    </div>
                    <div>
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-info btn-sm">View Tasks</a>
                    </div>
                </li>
            @empty
                <li class="list-group-item">No projects yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
