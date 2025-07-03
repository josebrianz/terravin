@extends('layout')

@section('title', 'Report Preferences')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Report Preferences for {{ $stakeholder->name }}</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('stakeholders.preferences.update', $stakeholder->id) }}">
        @csrf
        <div class="mb-3">
            <label>Frequency</label>
            <select name="frequency" class="form-control" required>
                @foreach(['daily','weekly','monthly'] as $freq)
                    <option value="{{ $freq }}" {{ (old('frequency', $preference->frequency ?? '') == $freq) ? 'selected' : '' }}>{{ ucfirst($freq) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Format</label>
            <select name="format" class="form-control" required>
                @foreach(['email','pdf','excel'] as $fmt)
                    <option value="{{ $fmt }}" {{ (old('format', $preference->format ?? '') == $fmt) ? 'selected' : '' }}>{{ strtoupper($fmt) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Report Types</label>
            <div>
                @foreach(['inventory','orders','sales & demand','supplier & vendor','financial & profitability'] as $type)
                    <label class="me-3">
                        <input type="checkbox" name="report_types[]" value="{{ $type }}"
                        {{ (is_array(old('report_types', $preference->report_types ?? [])) && in_array($type, old('report_types', $preference->report_types ?? []))) ? 'checked' : '' }}>
                        {{ ucfirst($type) }}
                    </label>
                @endforeach
            </div>
        </div>
        <button class="btn btn-success">Save Preferences</button>
        <a href="{{ route('stakeholders.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection 