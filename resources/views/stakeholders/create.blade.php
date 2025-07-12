@extends('layout')

@section('title', isset($stakeholder) ? 'Edit Stakeholder' : 'Add Stakeholder')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">{{ isset($stakeholder) ? 'Edit Stakeholder' : 'Add Stakeholder' }}</h1>
    <form method="POST" action="{{ isset($stakeholder) ? route('stakeholders.update', $stakeholder->id) : route('stakeholders.store') }}">
        @csrf
        @if(isset($stakeholder)) @method('PUT') @endif
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $stakeholder->name ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $stakeholder->email ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                @foreach(['wholesaler','company manager','wholesaler','sales manager'] as $role)
                    <option value="{{ $role }}" {{ (old('role', $stakeholder->role ?? '') == $role) ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success">{{ isset($stakeholder) ? 'Update' : 'Add' }}</button>
        <a href="{{ route('stakeholders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection 