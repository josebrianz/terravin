@extends('layout')

@section('title', 'Stakeholders')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Stakeholders</h1>
    <a href="{{ route('stakeholders.create') }}" class="btn btn-primary mb-3">Add Stakeholder</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Role</th><th>Preferences</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stakeholders as $s)
                <tr>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->email }}</td>
                    <td>{{ $s->role }}</td>
                    <td>
                        <a href="{{ route('stakeholders.preferences', $s->id) }}" class="btn btn-sm btn-info">View/Edit</a>
                    </td>
                    <td>
                        <a href="{{ route('stakeholders.edit', $s->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('stakeholders.destroy', $s->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 