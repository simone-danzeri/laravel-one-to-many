@extends('layouts.admin')
@section('content')
    <h3>{{ $project->name }}</h3>
    {{-- Flash Message --}}
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    {{-- Flash Message --}}
    <small class="my-1"><strong>Slug</strong>: {{ $project->slug }}</small>
    @if ($project->cover_image)
        <div class="my-5  pippo">
            <img width="200" src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->name }}">
        </div>
    @endif
    <div class="my-2"><strong>Made for</strong>: {{ $project->client_name }}</div>
    @if ($project->type)
        <div class="my-2"><strong>Project type</strong>: {{ $project->type->name }}</div>
    @else
        <div class="my-2"><strong>Project type</strong>: No project type</div>
    @endif
    @if ($project->summary)
        <p class="my-3"><strong>Summary of this project</strong>: {{ $project->summary }}</p>
    @else
        <p class="my-3"><strong>Summary of this project</strong>: There is no summary for you :/</p>
    @endif
    <div class="d-flex flex-column mb-5">
        <small><strong>Created at</strong>: {{ $project->created_at }}</small>
        <small><strong>Last updated at</strong>: {{ $project->updated_at }}</small>
    </div>
    <div class="my-2">
        <a class="btn btn-warning" href="{{ route('admin.projects.edit', ['project' => $project->slug]) }}">Edit<i class="fa-regular fa-pen-to-square px-2"></i></a>
    </div>
    <div class="my-2">
        <form action="{{ route('admin.projects.destroy', ['project' => $project->slug]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger js-delete-btn" data-project-name = "{{ $project->name }}" type="submit">Delete<i class="fa-solid fa-explosion px-2"></i></button>
        </form>
    </div>
    {{-- Modale --}}
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="confirmModalLabel"></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- qui ci andrà il testo della modale --}}
                Do you really want to delete this project?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" id="modalDeleteBtn">Delete</button>
            </div>
        </div>
        </div>
    </div>
@endsection
