<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Terravin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --burgundy: #5e0f0f;
            --burgundy-light: #7a2a2a;
            --gold: #c8a97e;
            --gold-light: #e0d0b8;
            --cream: #f5f0e6;
            --cream-dark: #e8e0d0;
            --white: #ffffff;
            --gray: #6c757d;
            --gray-light: #f8f9fa;
        }
        
        body { 
            background: var(--cream);
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }
        
        .chat-navbar {
            background: var(--burgundy);
            color: var(--gold);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            height: 60px;
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
        
        .chat-navbar .logout {
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
        
        .chat-navbar .logout:hover {
            background: var(--gold);
            color: var(--burgundy);
        }
        
        .chat-navbar .logout i {
            margin-right: 0.4rem;
        }
        
        .bg-burgundy { background-color: var(--burgundy) !important; }
        .bg-cream { background-color: var(--cream) !important; }
        .text-burgundy { color: var(--burgundy) !important; }
        .text-gold { color: var(--gold) !important; }
        
        .chat-container {
            display: flex;
            height: calc(100vh - 60px);
            min-height: 500px;
            overflow: hidden;
            position: relative;
            top: 60px; /* Pushes chat container below navbar */
        }
        
        /* Sidebar Styles */
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
        }
        
        .sidebar-header {
            padding: 0.75rem 1.25rem;
            background: var(--burgundy);
            color: var(--gold);
            display: flex;
            align-items: center;
            height: 60px;
        }
        
        .sidebar-header i {
            margin-right: 0.75rem;
            font-size: 1rem;
        }
        
        .sidebar-header span {
            font-weight: 500;
            font-size: 1.05rem;
        }
        
        .search-container {
            padding: 0.75rem 1rem;
            background: var(--white);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box input {
            padding-left: 2.5rem;
            border-radius: 18px;
            border: 1px solid rgba(0,0,0,0.1);
            background: var(--gray-light);
            font-size: 0.9rem;
        }
        
        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        .user-list {
            flex: 1;
            overflow-y: auto;
            max-height: calc(100vh - 60px - 120px); /* 60px navbar + 60px header + search */
        }
        
        .user-list-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            text-decoration: none;
            transition: background 0.2s;
            border-bottom: 1px solid rgba(0,0,0,0.03);
        }
        
        .user-list-item:hover {
            background: var(--cream-dark);
        }
        
        .user-list-item.active {
            background: var(--gold-light);
        }
        
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
        
        .user-info {
            flex: 1;
            min-width: 0;
        }
        
        .user-name {
            font-weight: 500;
            color: var(--burgundy);
            margin-bottom: 0.15rem;
            font-size: 0.95rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .user-email {
            font-size: 0.8rem;
            color: var(--gray);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .user-status {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        
        .user-time {
            font-size: 0.7rem;
            color: var(--gray);
            margin-bottom: 0.2rem;
        }
        
        .user-unread {
            background: var(--burgundy);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            font-weight: 500;
        }
        
        /* Chat Content Styles */
        .chat-content {
            flex: 1 1 0%;
            min-width: 0;
            display: flex;
            flex-direction: column;
            background: var(--cream);
            position: relative;
            overflow-y: auto;
            max-height: 100%;
        }
        .chat-area-navbar {
            background: var(--white);
            border-bottom: 1px solid #eee;
            height: 64px;
            min-height: 64px;
            z-index: 2;
        }
        .chat-content .user-avatar {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
            margin-right: 1rem;
        }
        .welcome-screen {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            padding: 2rem;
        }
        
        .welcome-icon {
            font-size: 5rem;
            color: var(--burgundy);
            opacity: 0.7;
            margin-bottom: 1.5rem;
        }
        
        .welcome-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--burgundy);
            margin-bottom: 1rem;
        }
        
        .welcome-text {
            font-size: 1.05rem;
            color: var(--gray);
            line-height: 1.6;
            max-width: 500px;
        }
        
        /* Scrollbar Styles */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.05);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.15);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0,0,0,0.2);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: absolute;
                z-index: 5;
                height: 100%;
            }
            
            .chat-content {
                display: none;
            }
            
            .chat-content.active {
                display: flex;
            }
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
        .exit-link i {
            margin-right: 0.4rem;
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
    
    <div class="chat-container">
                <!-- Sidebar: User List -->
        <div class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-users"></i>
                <span>Chats</span>
            </div>
            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" placeholder="Search contacts...">
                </div>
                    </div>
            <div class="user-list">
                        @forelse($users as $user)
                    <div class="user-list-item" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}">
                        <div class="user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                        <div class="user-info">
                            <div class="user-name">{{ $user->name }}</div>
                            {{-- <div class="user-email">{{ $user->email }}</div> --}} <!-- Removed email display -->
                            @if($user->latestMessage)
                                <div class="latest-message small text-muted">{{ Str::limit($user->latestMessage->message, 30) }}</div>
                            @endif
                        </div>
                        <div class="user-status">
                            <div class="user-time">{{ $user->latestTime }}</div>
                            @if($user->unreadCount > 0)
                                <div class="user-unread">{{ $user->unreadCount }}</div>
                            @endif
                                </div>
                    </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                        <i class="fas fa-users fa-2x mb-3"></i>
                        <div>No contacts available</div>
                        <small class="d-block mt-2">Your contacts will appear here</small>
                            </div>
                        @endforelse
                    </div>
                </div>
        <!-- Main Chat Area -->
        <div class="chat-content" id="chat-content">
            <!-- Chat area top navbar (profile info) -->
            <div class="chat-area-navbar d-flex align-items-center px-3 py-2 bg-white border-bottom" style="height: 64px; min-height: 64px;">
                <div id="chat-profile-avatar" class="user-avatar me-3" style="width: 40px; height: 40px; font-size: 1.1rem; background: var(--burgundy); color: var(--gold);"> <i class="fas fa-user"></i> </div>
                <div>
                    <div id="chat-profile-name" class="fw-bold text-burgundy">Select a chat</div>
                    <div id="chat-profile-email" class="small text-muted"></div>
                </div>
            </div>
            <div class="welcome-screen flex-grow-1 d-flex flex-column align-items-center justify-content-center" id="chat-placeholder">
                <i class="fas fa-comments welcome-icon"></i>
                <h2 class="welcome-title">Welcome to Terravin Chat</h2>
                <p class="welcome-text">
                    Select a chat to start Conversations.
                </p>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.4/dist/index.min.js"></script>
    <script>
        // Simple search functionality
        document.querySelector('.search-box input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const userItems = document.querySelectorAll('.user-list-item');
            userItems.forEach(item => {
                const userName = item.querySelector('.user-name').textContent.toLowerCase();
                const userEmail = item.querySelector('.user-email').textContent.toLowerCase();
                if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
        function enableAttachmentPreview() {
            const attachmentInput = document.getElementById('chat-attachment');
            const preview = document.getElementById('attachment-preview');
            if (attachmentInput && preview) {
                attachmentInput.onchange = function() {
                    preview.innerHTML = '';
                    if (this.files && this.files[0]) {
                        const file = this.files[0];
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.innerHTML = `<img src='${e.target.result}' alt='preview' style='max-width:100px;max-height:100px;' class='me-2'/>`;
                            };
                            reader.readAsDataURL(file);
                        } else {
                            preview.innerHTML = `<span class='badge bg-secondary'>${file.name}</span>`;
                        }
                    }
                };
            }
        }
        function enableAjaxChatForm() {
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const messagesArea = document.getElementById('messages-area');
            const attachmentInput = document.getElementById('chat-attachment');
            const preview = document.getElementById('attachment-preview');
            if (chatForm && chatInput && messagesArea) {
                chatForm.onsubmit = null;
                chatForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(chatForm); // Includes file
                    // Debug: log FormData entries
                    for (let [key, value] of formData.entries()) {
                        console.log(key, value);
                    }
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
                            if (attachmentInput) attachmentInput.value = '';
                            if (preview) preview.innerHTML = '';
                            messagesArea.scrollTop = messagesArea.scrollHeight;
                        } else {
                            alert('Message send failed!');
                        }
                    })
                    .catch(err => {
                        alert('AJAX error: ' + err);
                    });
                });
            }
        }
        function enableEmojiPicker() {
            const button = document.getElementById('emoji-btn');
            const input = document.getElementById('chat-input');
            if (button && input && window.EmojiButton) {
                const picker = new window.EmojiButton();
                picker.on('emoji', emoji => {
                    input.value += emoji;
                });
                button.onclick = function() {
                    picker.togglePicker(button);
                };
            }
        }
        function enableAttachmentButton() {
            const attachmentInput = document.getElementById('chat-attachment');
            const attachBtn = document.getElementById('attach-btn');
            if (attachBtn && attachmentInput) {
                attachBtn.onclick = function() {
                    attachmentInput.click();
                };
            }
        }
        // Enable AJAX chat switching
        document.querySelectorAll('.user-list-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.user-list-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                const userId = this.getAttribute('data-user-id');
                fetch(`/chat/${userId}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.html) {
                        document.getElementById('chat-content').innerHTML = data.html;
                        enableAjaxChatForm();
                        enableEmojiPicker();
                        enableAttachmentButton();
                        enableAttachmentPreview();
                    } else {
                        alert('Failed to load chat conversation!');
                    }
                })
                .catch(err => {
                    alert('AJAX error: ' + err);
                });
            });
        });
        // Enable on initial page load
        enableAjaxChatForm();
        enableEmojiPicker();
        enableAttachmentButton();
        enableAttachmentPreview();
        // Delete message
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-message-btn')) {
            const btn = e.target.closest('.delete-message-btn');
            const messageId = btn.getAttribute('data-message-id');
            if (confirm('Delete this message?')) {
                fetch(`/chat/message/${messageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        btn.closest('.mb-3').remove();
                    }
                });
            }
        }
    });
    // Edit message
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-message-btn')) {
            const btn = e.target.closest('.edit-message-btn');
            const messageId = btn.getAttribute('data-message-id');
            const oldText = btn.getAttribute('data-message-text');
            const newText = prompt('Edit your message:', oldText);
            if (newText !== null && newText.trim() !== '' && newText !== oldText) {
                fetch(`/chat/message/${messageId}`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ message: newText })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Update the message text in the bubble
                        const bubble = btn.closest('.mb-3').querySelector('div[style*="word-break"]');
                        if (bubble && bubble.childNodes.length > 0) {
                            bubble.childNodes[0].textContent = newText;
                        }
                        btn.setAttribute('data-message-text', newText);
                    }
                });
            }
        }
    });
    </script>
</body>
</html>