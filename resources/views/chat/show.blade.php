<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with {{ $other->name }} - Terravin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --burgundy: #5e0f0f;
            --gold: #c8a97e;
            --cream: #f5f0e6;
            --white: #ffffff;
            --gray: #6c757d;
        }
        body { background: var(--cream); font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif; }
        .chat-navbar {
            background: var(--burgundy);
            color: var(--gold);
            padding: 0.5rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            height: 48px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10;
        }
        .chat-navbar .brand {
            font-size: 1.25rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
        }
        .chat-navbar .brand i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }
        .exit-link {
            color: var(--gold);
            border: 1px solid var(--gold);
            border-radius: 20px;
            padding: 0.35rem 1rem;
            background: transparent;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        .exit-link:hover {
            background: var(--gold);
            color: var(--burgundy);
        }
        .exit-link i { margin-right: 0.4rem; }
        .chat-container {
            display: flex;
            height: calc(100vh - 48px);
            min-height: 500px;
            overflow: hidden;
            position: relative;
            top: 48px;
        }
        .sidebar {
            width: 320px;
            min-width: 280px;
            border-right: 1px solid rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            background: var(--white);
            transition: all 0.3s ease;
            overflow-y: auto;
            max-height: 100%;
            margin-left: 0;
        }
        .sidebar-header {
            padding: 0.75rem 1.25rem;
            background: var(--burgundy);
            color: var(--gold);
            display: flex;
            align-items: center;
            height: 60px;
        }
        .sidebar-header i { margin-right: 0.75rem; font-size: 1rem; }
        .sidebar-header span { font-weight: 500; font-size: 1.05rem; }
        .user-list { flex: 1; overflow-y: auto; max-height: calc(100vh - 60px - 60px); }
        .user-list-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            text-decoration: none;
            transition: background 0.2s;
            border-bottom: 1px solid rgba(0,0,0,0.03);
        }
        .user-list-item:hover { background: var(--cream); }
        .user-list-item.active { background: var(--gold); color: var(--burgundy); }
        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--burgundy);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }
        .user-info { flex: 1; min-width: 0; }
        .user-name { font-weight: 500; color: var(--burgundy); margin-bottom: 0.15rem; font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-email { font-size: 0.8rem; color: var(--gray); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-status { display: flex; flex-direction: column; align-items: flex-end; }
        .user-time { font-size: 0.7rem; color: var(--gray); margin-bottom: 0.2rem; }
        .user-unread { background: var(--burgundy); color: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 0.6rem; font-weight: 500; }
        .chat-content { flex: 1; display: flex; flex-direction: column; background: var(--cream); position: relative; overflow-y: auto; max-height: 100%; }
        .chat-area-navbar { background: var(--white); border-bottom: 1px solid #eee; height: 64px; min-height: 64px; z-index: 2; display: flex; align-items: center; padding: 0 1.5rem; }
        .chat-content .user-avatar { width: 40px; height: 40px; font-size: 1.1rem; margin-right: 1rem; }
        .messages-area { flex: 1; overflow-y: auto; padding: 1.5rem 2rem 1rem 2rem; }
        .wine-bubble-me { background: var(--burgundy); color: #fff; border-top-right-radius: 0.5rem !important; border-bottom-left-radius: 1.5rem !important; }
        .wine-bubble-other { background: #fff; color: var(--burgundy); border: 1px solid var(--gold); border-top-left-radius: 0.5rem !important; border-bottom-right-radius: 1.5rem !important; }
        .wine-input { border-radius: 2rem 0 0 2rem; border: 1px solid var(--gold); }
        .send-area { background: var(--cream); border-top: 1px solid #eee; padding: 1rem 2rem; }
        ::-webkit-scrollbar { width: 8px; background: var(--cream); }
        ::-webkit-scrollbar-thumb { background: #e0d6c3; border-radius: 4px; }
        .side-nav-bar {
            background: var(--burgundy) !important;
            width: 60px;
            min-width: 60px;
            min-height: 100vh;
            border-right: 3px solid #4a0c0c;
            z-index: 3;
            box-shadow: 2px 0 8px rgba(94,15,15,0.08);
        }
        .side-nav-icon {
            color: var(--gold);
            font-size: 1.5rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            margin-bottom: 1rem;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
        }
        .side-nav-icon.active, .side-nav-icon:hover {
            background: var(--gold);
            color: var(--burgundy);
        }
    </style>
</head>
<body>
    <nav class="chat-navbar">
        <div class="brand">
            <i class="fas fa-comments"></i> Terravin Chat
        </div>
        <a href="/dashboard" class="exit-link">
            <i class="fas fa-arrow-left"></i> Exit
        </a>
    </nav>
    <div class="chat-container" style="display: flex; height: calc(100vh - 48px); min-height: 500px; position: relative; top: 48px;">
        <div class="side-nav-bar" style="background: #5e0f0f; width: 60px; min-width: 60px; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding-top: 1rem;">
            <a href="#" style="color: #c8a97e; font-size: 1.5rem; margin-bottom: 1rem;"><i class="fas fa-comments"></i></a>
            <a href="#" style="color: #c8a97e; font-size: 1.5rem;"><i class="fas fa-user"></i></a>
        </div>
        <div class="sidebar" style="width: 320px; background: #fff;">
            <div class="sidebar-header">
                <i class="fas fa-users"></i>
                <span>Chats</span>
                    </div>
            <div class="user-list">
                        @foreach($users as $user)
                    <a href="{{ route('chat.show', $user->id) }}" class="user-list-item{{ $user->id == $other->id ? ' active' : '' }}">
                        <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        <div class="user-info">
                            <div class="user-name">{{ $user->name }}</div>
                            <div class="user-email">{{ $user->email }}</div>
                                </div>
                        <div class="user-status">
                            <div class="user-time">12:30 PM</div>
                            <div class="user-unread">3</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
        <div class="chat-content" style="flex: 1; background: #f5f0e6;">
            @include('chat._conversation', ['other' => $other, 'messages' => $messages])
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
        // Auto-scroll to bottom of messages
document.addEventListener('DOMContentLoaded', function() {
            var messageContainer = document.querySelector('.messages-area');
    if (messageContainer) {
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }
});

        // AJAX send message
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const messagesArea = document.getElementById('messages-area');
        if (chatForm && chatInput && messagesArea) {
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(chatForm);
                fetch(chatForm.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.html) {
                        messagesArea.insertAdjacentHTML('beforeend', data.html);
                        chatInput.value = '';
                        messagesArea.scrollTop = messagesArea.scrollHeight;
                    }
                });
            });
        }
</script>
</body>
</html> 