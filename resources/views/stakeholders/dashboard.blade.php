@extends('layout')

@section('title', 'Stakeholder Preferences Dashboard ')

@section('content')
<nav class="navbar navbar-expand-lg" style="background: #6b1a15; border-radius: 0 0 12px 12px; box-shadow: 0 2px 8px rgba(107,26,21,0.08);">
  <div class="container-fluid py-2">
    <a class="navbar-brand fw-bold" href="#" style="color: #bfa14a; font-size: 2rem; letter-spacing: 2px;">Terravin</a>
  </div>
</nav>
<div class="container-fluid py-4 wine-theme-bg" style="border-radius: 0; box-shadow: none;">
    <div class="wine-accent-bar" style="margin-bottom: 0;"></div>
    <h1 class="mb-4 fw-bold text-center" style="font-size: 3rem; color: #6b1a15; text-shadow: 2px 2px 8px #e0bcbc; letter-spacing: 2px;">Stakeholder Preferences</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- List Stakeholders --}}
    <div class="table-responsive p-0 m-0" style="border-radius: 0;">
        <table id="stakeholders-table" class="table table-bordered table-hover table-lg align-middle w-100 m-0" style="font-size: 1.1rem; border-radius: 0;">
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
                        <a href="{{ route('stakeholders.reports', $stakeholder->id) }}" class="btn btn-sm btn-info mt-1">View Report (PDF)</a>
                        <a href="{{ route('stakeholders.reports', $stakeholder->id) }}?download=1" class="btn btn-sm btn-success mt-1">Download Report (PDF)</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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

<style>
.wine-theme-bg {
    background: linear-gradient(135deg, #f8f6f3 60%, #fbeee6 100%);
    border-radius: 0;
    box-shadow: none;
    padding-bottom: 0;
}
.wine-accent-bar {
    height: 8px;
    background: linear-gradient(90deg, #6b1a15 60%, #bfa14a 100%);
    border-radius: 8px 8px 0 0;
    margin-bottom: 1.5rem;
}
.stakeholder-table-card {
    background: #fff;
    border-radius: 0;
    box-shadow: none;
    padding: 0;
    margin-bottom: 0;
}
#stakeholders-table thead th {
    background: #f8f9fa;
    z-index: 2;
}
/* Let table be responsive and content wrap naturally */
#stakeholders-table th, #stakeholders-table td {
    word-break: break-word;
    white-space: normal;
}
#editStakeholderModal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    z-index: 9999;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0,0,0,0.3);
    min-width: 300px;
    display: none;
}
#modalBackdrop {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.4);
    z-index: 9998;
    display: none;
}
</style>
<div id="modalBackdrop"></div>

<script>
function showEditForm(id, name, email, role) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_role').value = role;
    document.getElementById('editStakeholderModal').style.display = 'block';
    document.getElementById('modalBackdrop').style.display = 'block';
    document.getElementById('editStakeholderForm').action = '/stakeholders/' + id;
}
function hideEditForm() {
    document.getElementById('editStakeholderModal').style.display = 'none';
    document.getElementById('modalBackdrop').style.display = 'none';
}
document.getElementById('modalBackdrop').onclick = hideEditForm;
</script>
@endsection 