<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Notifications | Terravin Wines</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8f6f3; font-family: 'Montserrat', sans-serif; }
        .notification-list { max-width: 700px; margin: 2rem auto; }
        .notification-card { background: white; border-radius: 10px; box-shadow: 0 3px 15px rgba(94, 15, 15, 0.08); padding: 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: flex-start; }
        .notification-icon { font-size: 1.5rem; color: #e0c68a; margin-right: 1.2rem; margin-top: 3px; }
        .notification-content { flex: 1; }
        .notification-title { font-weight: 600; color: #5e0f0f; margin-bottom: 0.3rem; }
        .notification-time { font-size: 0.8rem; color: #5e0f0f; opacity: 0.7; }
        .notification-message { margin-bottom: 0.5rem; }
        .mark-read-btn { background: #5e0f0f; color: #fff; border: none; border-radius: 20px; padding: 0.3rem 1.2rem; font-size: 0.9rem; transition: all 0.2s; }
        .mark-read-btn:hover { background: #a67c00; color: #fff; }
        .read { opacity: 0.6; }
        .back-link { color: #5e0f0f; text-decoration: none; font-weight: 500; }
        .back-link:hover { color: #a67c00; text-decoration: underline; }
    </style>
</head>
<body>
<div class="container notification-list">
    <h1 class="mb-4 text-center" style="color:#5e0f0f; font-weight: bold;">All Notifications</h1>
    <div class="mb-3 text-center">
        <a href="{{ route('retailer.dashboard') }}" class="back-link"><i class="fas fa-arrow-left me-2"></i>Back to Dashboard</a>
    </div>
    @foreach($notifications as $note)
        <div class="notification-card @if($note->read_at) read @endif">
            <div class="notification-icon">
                <i class="fas fa-{{ $note->icon ?? 'bell' }}"></i>
            </div>
            <div class="notification-content">
                <div class="notification-title">{{ $note->title }}</div>
                <div class="notification-message">{{ $note->message }}</div>
                <div class="notification-time">{{ $note->created_at->diffForHumans() }}</div>
                @if(!$note->read_at)
                <form action="{{ route('retailer.notifications.read', $note->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="mark-read-btn">Mark as Read</button>
                </form>
                @else
                <span class="badge bg-success">Read</span>
                @endif
            </div>
        </div>
    @endforeach
    <div class="d-flex justify-content-center mt-4">
        {{ $notifications->links() }}
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 