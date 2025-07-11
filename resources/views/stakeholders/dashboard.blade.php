@extends('layout')

@section('title', 'Stakeholder Preferences Dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Stakeholder Preferences Dashboard</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- List Stakeholders --}}
    <div class="mb-5">
        <h3>All Stakeholders</h3>
        <div style="max-height: 70vh; min-height: 40vh; overflow-y: auto;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Report Preferences</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stakeholders as $stakeholder)
                <tr>
                    <td>{{ $stakeholder->name }}</td>
                    <td>{{ $stakeholder->email }}</td>
                    <td>{{ $stakeholder->role }}</td>
                    <td>
                        <form method="POST" action="{{ route('stakeholders.preferences.update', $stakeholder->id) }}">
                            @csrf
                            <div class="mb-2">
                                <label>Frequency</label>
                                <select name="frequency" class="form-control form-control-sm" required>
                                    @foreach(['daily','weekly','monthly'] as $freq)
                                        <option value="{{ $freq }}" {{ (optional($stakeholder->reportPreference)->frequency == $freq) ? 'selected' : '' }}>{{ ucfirst($freq) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label>Format</label>
                                <select name="format" class="form-control form-control-sm" required>
                                    @foreach(['email','pdf','excel'] as $fmt)
                                        <option value="{{ $fmt }}" {{ (optional($stakeholder->reportPreference)->format == $fmt) ? 'selected' : '' }}>{{ strtoupper($fmt) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label>Report Types</label><br>
                                @php $selectedTypes = optional($stakeholder->reportPreference)->report_types ?? []; @endphp
                                @foreach(['inventory','orders','sales & demand','supplier & vendor','financial & profitability'] as $type)
                                    <label class="me-2">
                                        <input type="checkbox" name="report_types[]" value="{{ $type }}" {{ in_array($type, $selectedTypes) ? 'checked' : '' }}> {{ ucfirst($type) }}
                                    </label>
                                @endforeach
                            </div>
                            <button class="btn btn-sm btn-success">Save</button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="showEditForm({{ $stakeholder->id }}, '{{ $stakeholder->name }}', '{{ $stakeholder->email }}', '{{ $stakeholder->role }}')">Edit</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>

    {{-- Create Stakeholder Form --}}
    <div class="mb-5">
        <h3>Add New Stakeholder</h3>
        <form method="POST" action="{{ route('stakeholders.store') }}">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="text" name="role" class="form-control" placeholder="Role" required>
            </div>
            <button type="submit" class="btn btn-success">Add Stakeholder</button>
        </form>
    </div>

    {{-- Edit Stakeholder Modal/Form (hidden by default) --}}
    <div id="editStakeholderModal" style="display:none;">
        <h3>Edit Stakeholder</h3>
        <form id="editStakeholderForm" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit_id">
            <div class="mb-3">
                <input type="text" name="name" id="edit_name" class="form-control" placeholder="Name" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" id="edit_email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="text" name="role" id="edit_role" class="form-control" placeholder="Role" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Stakeholder</button>
            <button type="button" class="btn btn-secondary" onclick="hideEditForm()">Cancel</button>
        </form>
    </div>
</div>

<script>
function showEditForm(id, name, email, role) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_role').value = role;
    document.getElementById('editStakeholderModal').style.display = 'block';
    document.getElementById('editStakeholderForm').action = '/stakeholders/' + id;
}
function hideEditForm() {
    document.getElementById('editStakeholderModal').style.display = 'none';
}
</script>
@endsection 