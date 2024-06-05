@extends('layouts.admin')
@section('content')
    <h1 class="mb-4">Projects List</h1>
        {{-- Flash Message --}}
        <div>
            @if (session()->has('message'))
                <div class="alert alert-danger">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        {{-- Flash Message --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Project Name</th>
                <th>Slug</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->slug }}</td>
                    <td>{{ $project->created_at }}</td>
                    {{-- qui tutte le actions --}}
                    <td>
                        <div class="my-1">
                            <a class="btn btn-primary" href="{{ route('admin.projects.show', ['project' => $project->slug]) }}">View<i class="fa-solid fa-magnifying-glass px-2"></i></a>
                        </div>
                        <div class="my-1">
                            <a class="btn btn-warning" href="{{ route('admin.projects.edit', ['project' => $project->slug]) }}">Edit<i class="fa-regular fa-pen-to-square px-2"></i></a>
                        </div>
                        <div class="my-1">
                            <form action="{{ route('admin.projects.destroy', ['project' => $project->slug]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger js-delete-btn" data-project-name = "{{ $project->name }}" type="submit">Delete<i class="fa-solid fa-explosion px-2"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-4">
        <a href="#" class="btn btn-primary">Back Top</a>
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
