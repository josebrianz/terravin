<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | TERRAVIN WINE</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --burgundy: #5e0f0f;
            --gold: #c8a97e;
            --cream: #f5f0e6;
            --light-burgundy: #8b1a1a;
            --dark-gold: #b8945f;
        }
        body { font-family: 'Montserrat', sans-serif; background: var(--cream); margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 2rem auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 16px rgba(94,15,15,0.08); padding: 2.5rem; }
        h1 { color: var(--burgundy); margin-bottom: 2rem; }
        .wine-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(94, 15, 15, 0.08); padding: 2rem; margin-bottom: 2rem; }
        .form-label { color: var(--burgundy); font-weight: 600; }
        .btn-burgundy { background: var(--burgundy); color: #fff; border: none; }
        .btn-burgundy:hover { background: var(--gold); color: var(--burgundy); }
        .btn-outline-burgundy { background: none; color: var(--burgundy); border: 1px solid var(--burgundy); }
        .btn-outline-burgundy:hover { background: var(--burgundy); color: #fff; }
        .btn-outline-danger { background: none; color: #b94a48; border: 1px solid #b94a48; }
        .btn-outline-danger:hover { background: #b94a48; color: #fff; }
        @media (max-width: 600px) { .container { padding: 1rem; } }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user-edit text-gold me-2"></i> Edit User</h1>
        <div class="wine-card">
            <form method="POST" action="{{ route('admin.update-user', $user->id) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="">Select Role</option>
                        @foreach($availableRoles as $roleName => $roleData)
                            <option value="{{ $roleName }}" {{ $user->role === $roleName ? 'selected' : '' }}>
                                {{ $roleName }} - {{ $roleData['description'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password <span class="text-muted">(leave blank to keep current)</span></label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.manage-roles') }}" class="btn btn-outline-burgundy"><i class="fas fa-arrow-left"></i> Back</a>
                    <button type="submit" class="btn btn-burgundy"><i class="fas fa-save"></i> Update User</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 