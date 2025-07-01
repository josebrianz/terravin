@extends('layouts.app')

@section('title', 'Chat Dashboard')

@section('content')
<link rel="stylesheet" href="/css/style.css">
<style>
    .chat-dashboard-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
    }
    .chat-dashboard-title {
        font-family: 'Playfair Display', serif;
        color: var(--burgundy);
        font-size: 2rem;
        font-weight: bold;
    }
    .chat-container {
        display: flex;
        gap: 2rem;
        background: var(--cream);
        border-radius: 18px;
        box-shadow: 0 4px 32px rgba(94, 15, 15, 0.08);
        padding: 2rem;
        min-height: 500px;
    }
    .user-list {
        width: 280px;
        background: var(--gold);
        border-radius: 12px;
        padding: 1rem 0.5rem;
        box-shadow: 0 2px 8px rgba(94, 15, 15, 0.05);
        overflow-y: auto;
        max-height: 600px;
    }
    .user-list-search {
        margin-bottom: 1rem;
        width: 100%;
        border-radius: 8px;
        border: 1px solid var(--burgundy);
        padding: 0.5rem 1rem;
    }
    .user-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.7rem 1rem;
        border-radius: 8px;
        cursor: pointer;
        margin-bottom: 0.5rem;
        transition: background 0.2s;
    }
    .user-item.active, .user-item:hover {
        background: var(--burgundy);
        color: var(--gold);
    }
    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--cream);
        color: var(--burgundy);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        font-weight: bold;
        border: 2px solid var(--burgundy);
    }
    .online-dot {
        width: 10px;
        height: 10px;
        background: #28a745;
        border-radius: 50%;
        margin-left: 6px;
        display: inline-block;
    }
    .chat-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(94, 15, 15, 0.05);
        padding: 1.5rem;
        min-width: 0;
    }
    .chat-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 0.7rem;
    }
    .chat-header .user-avatar {
        width: 44px;
        height: 44px;
        font-size: 1.5rem;
    }
    .chat-header .user-name {
        font-weight: bold;
        color: var(--burgundy);
        font-size: 1.1rem;
    }
    #chat-box {
        flex: 1;
        overflow-y: auto;
        margin-bottom: 1rem;
        padding-right: 0.5rem;
    }
    .chat-bubble {
        max-width: 70%;
        padding: 0.7rem 1.1rem;
        border-radius: 16px 16px 8px 16px;
        margin-bottom: 0.7rem;
        font-size: 1rem;
        position: relative;
        word-break: break-word;
        box-shadow: 0 2px 8px rgba(94, 15, 15, 0.06);
        border: 1px solid #ececec;
        background: #fff;
        color: var(--burgundy);
        transition: background 0.2s, color 0.2s;
    }
    .chat-bubble.sent {
        background: linear-gradient(120deg, var(--gold) 80%, #fff 100%);
        color: var(--burgundy);
        margin-left: auto;
        border-bottom-right-radius: 6px;
        border: 1px solid var(--gold);
    }
    .chat-bubble.received {
        background: linear-gradient(120deg, #f8f5f0 80%, #fff 100%);
        color: var(--burgundy);
        margin-right: auto;
        border-bottom-left-radius: 6px;
        border: 1px solid #ececec;
    }
    .bubble-meta {
        font-size: 0.8rem;
        color: #888;
        margin-top: 0.2rem;
        text-align: right;
    }
    .chat-input-bar {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--cream);
        border-radius: 10px;
        padding: 0.7rem 1rem;
        box-shadow: 0 1px 4px rgba(94, 15, 15, 0.04);
    }
    .chat-input-bar input[type="text"] {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 1rem;
        color: var(--burgundy);
        outline: none;
    }
    .chat-input-bar .send-btn {
        background: var(--burgundy);
        color: var(--gold);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1.2rem;
        font-weight: bold;
        transition: background 0.2s;
    }
    .chat-input-bar .send-btn:hover {
        background: var(--gold);
        color: var(--burgundy);
    }
    .chat-input-bar .emoji-btn, .chat-input-bar .file-label {
        background: none;
        border: none;
        font-size: 1.3rem;
        cursor: pointer;
        color: var(--burgundy);
    }
    .chat-bubble.sent .bubble-actions {
        display: none;
    }
    .chat-bubble.sent.show-actions .bubble-actions {
        display: flex;
        gap: 2px;
    }
    .bubble-actions {
        display: none;
        position: absolute;
        top: 6px;
        right: 10px;
        z-index: 2;
        background: rgba(255,255,255,0.95);
        border-radius: 8px;
        padding: 2px 4px;
        box-shadow: 0 2px 8px rgba(94, 15, 15, 0.06);
    }
    .chat-bubble.sent:hover .bubble-actions,
    .chat-bubble.sent:focus-within .bubble-actions,
    .chat-bubble.sent.show-actions .bubble-actions {
        display: flex;
        gap: 2px;
    }
    @media (hover: none) and (pointer: coarse) {
        .bubble-actions { background: var(--cream); }
    }
    @media (max-width: 900px) {
        .chat-container { flex-direction: column; gap: 1rem; }
        .user-list { width: 100%; max-height: 180px; margin-bottom: 1rem; }
        .chat-main { min-height: 300px; padding: 1rem; }
        .chat-header { flex-direction: row; gap: 0.5rem; }
        .chat-input-bar { flex-direction: column; gap: 0.5rem; padding: 0.7rem 0.5rem; }
        .chat-input-bar input[type="text"] { font-size: 1.1rem; }
        .send-btn, .emoji-btn, .file-label { font-size: 1.1rem; padding: 0.7rem 1.5rem; }
        .user-item { font-size: 1.1rem; padding: 1rem 1.2rem; }
        .user-avatar { width: 44px; height: 44px; font-size: 1.5rem; }
    }
    @media (max-width: 600px) {
        .chat-dashboard-header { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
        .chat-dashboard-title { font-size: 1.3rem; }
        .user-list { max-height: 120px; }
        .chat-main { padding: 0.5rem; }
        .chat-bubble { font-size: 0.95rem; padding: 0.5rem 0.8rem; }
        .user-item { font-size: 1rem; padding: 0.7rem 0.8rem; }
        .user-avatar { width: 36px; height: 36px; font-size: 1.1rem; }
    }
    :root {
        --burgundy: #5e0f0f;
        --gold: #e0b973;
        --cream: #f8f5f0;
        --dark-bg: #232323;
        --dark-card: #2d2d2d;
        --dark-text: #f8f5f0;
        --dark-accent: #e0b973;
    }
    body.dark-mode {
        --burgundy: #e0b973;
        --gold: #5e0f0f;
        --cream: #232323;
        --bg: #232323;
        --text: #f8f5f0;
    }
    .bubble-actions-dropdown {
        position: absolute;
        top: 50%;
        right: -32px;
        transform: translateY(-50%);
        z-index: 10;
        display: none;
        align-items: center;
    }
    .chat-bubble.sent.show-chevron .bubble-actions-dropdown {
        display: flex;
    }
    .bubble-menu-btn {
        background: none;
        border: none;
        color: #888;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 50%;
        transition: background 0.2s, transform 0.2s;
    }
    .bubble-menu-btn.open {
        color: var(--burgundy);
        transform: rotate(90deg);
    }
    .bubble-dropdown-menu {
        display: none;
        position: absolute;
        top: 28px;
        right: 0;
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(94, 15, 15, 0.08);
        min-width: 170px;
        width: 200px;
        padding: 4px 0;
    }
    .bubble-dropdown-menu.show {
        display: block;
    }
    .bubble-dropdown-menu button {
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        padding: 6px 16px;
        color: #5e0f0f;
        font-size: 0.98rem;
        cursor: pointer;
        border-radius: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .bubble-dropdown-menu button i {
        min-width: 20px;
        text-align: center;
    }
    .bubble-dropdown-menu button:hover {
        background: #f8f5f0;
    }
</style>
<div class="container py-4">
    <div class="chat-dashboard-header">
        <div class="chat-dashboard-title">
            <i class="fas fa-comments me-2 text-burgundy"></i> Chat Dashboard
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-muted me-2">Welcome, {{ Auth::user()->name }}</div>
            <button id="theme-toggle" class="btn btn-sm btn-outline-secondary" title="Toggle theme"><i class="fas fa-moon"></i></button>
        </div>
    </div>
    <div class="chat-container">
        <div class="user-list" id="user-list">
            <input type="text" class="user-list-search" placeholder="Search users..." id="user-search">
            @foreach($users as $user)
                @php
                    $isOnline = $user->id !== 'group' && $user->last_seen && \Carbon\Carbon::parse($user->last_seen)->gt(now()->subMinutes(2));
                    $unread = $unreadCounts[$user->id] ?? 0;
                @endphp
                <div class="user-item" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email ?? '' }}" data-user-role="{{ $user->role ?? '' }}">
                    <div class="user-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <span>{{ $user->name }}</span>
                    @if($user->id !== 'group')
                        <span class="online-dot" style="background: {{ $isOnline ? '#28a745' : '#ccc' }};"></span>
                        <button class="btn btn-link btn-sm p-0 ms-1 user-info-btn" title="View profile" data-user-id="{{ $user->id }}"><i class="fas fa-info-circle"></i></button>
                    @endif
                    @if($unread > 0)
                        <span class="badge bg-danger ms-2">{{ $unread }}</span>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="chat-main">
            <div class="chat-header" id="chat-header" style="display:none;">
                <div class="user-avatar" id="chat-user-avatar"></div>
                <div class="user-name" id="chat-user-name"></div>
            </div>
            <input type="text" id="chat-search" class="form-control mb-2" placeholder="Search messages..." style="display:none;">
            <div id="chat-box"></div>
            <div id="reply-bar" style="display:none;" class="mb-2">
                <div class="d-flex align-items-center justify-content-between bg-light border rounded px-3 py-2">
                    <div class="flex-grow-1">
                        <span class="fw-bold text-burgundy" id="reply-author"></span>
                        <span class="text-muted small" id="reply-preview"></span>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-danger ms-2" id="cancel-reply-btn" title="Cancel reply"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div id="typing-indicator" style="min-height: 24px; color: #888; font-style: italic; display: none;"></div>
            <form id="chat-form" enctype="multipart/form-data" class="chat-input-bar position-relative">
                @csrf
                <input type="hidden" name="receiver_id" id="receiver_id">
                <button type="button" id="emoji-btn" class="emoji-btn" title="Emoji">😊</button>
                <label for="file-input" class="file-label" title="Attach file">📎</label>
                <input type="file" name="file" id="file-input" style="display:none;">
                <input type="text" name="message" id="message-input" class="form-control" placeholder="Type a message...">
                <button type="submit" class="send-btn">Send</button>
                <div id="emoji-picker" class="emoji-picker" style="display:none;"></div>
            </form>
        </div>
    </div>
</div>

<!-- User Profile Modal -->
<div class="modal fade" id="userProfileModal" tabindex="-1" aria-labelledby="userProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userProfileModalLabel">User Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center mb-3">
          <div class="user-avatar me-3" id="profile-avatar" style="width:48px;height:48px;font-size:1.7rem;"></div>
          <div>
            <div class="fw-bold" id="profile-name"></div>
            <div class="text-muted small" id="profile-role"></div>
          </div>
        </div>
        <div><strong>Email:</strong> <span id="profile-email"></span></div>
      </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="/js/echo.js"></script>
<script>
    let selectedUserId = null;
    let selectedUserName = '';
    let selectedGroup = null;
    const userId = {{ auth()->id() }};
    let allMessages = [];

    // User search
    document.getElementById('user-search').addEventListener('input', function() {
        const val = this.value.toLowerCase();
        document.querySelectorAll('.user-item').forEach(item => {
            const name = item.dataset.userName.toLowerCase();
            item.style.display = name.includes(val) ? '' : 'none';
        });
    });

    function fetchMessages(userId) {
        axios.get(`/chat/messages/${userId}`).then(res => {
            const chatBox = document.getElementById('chat-box');
            allMessages = res.data;
            renderMessages(allMessages);
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    }

    function renderMessages(messages) {
        const chatBox = document.getElementById('chat-box');
        chatBox.innerHTML = '';
        messages.forEach(msg => {
            chatBox.innerHTML += renderMessage(msg);
        });
    }

    function renderMessage(msg) {
        let isSent = msg.sender_id == userId;
        let bubbleClass = isSent ? 'sent' : 'received';
        let html = `<div class='d-flex ${isSent ? 'justify-content-end' : 'justify-content-start'}'>`;
        html += `<div class='chat-bubble ${bubbleClass}' tabindex='0' data-msg-id='${msg.id}' style='position:relative;'>`;
        // Reply preview
        if (msg.reply_message) {
            html += `<div class='border-start ps-2 mb-1 small reply-preview' style='border-color: var(--gold); cursor:pointer;' onclick='scrollToMessage(${msg.reply_message.id})'>`;
            html += `<span class='text-gold'>&#8618;</span> <span class='fw-bold'>Replied to ${msg.reply_message.sender_id == userId ? 'You' : (msg.reply_message.sender_name || 'User')}</span>: `;
            html += `<span class='text-muted'>${msg.reply_message.message ? msg.reply_message.message.substring(0, 40) : '[file]'}</span>`;
            html += `</div>`;
        }
        if (msg.file) {
            const fileUrl = `/storage/${msg.file}`;
            const fileName = msg.file.split('/').pop();
            const isImage = /\.(jpg|jpeg|png|gif|bmp|webp)$/i.test(fileName);
            if (isImage) {
                html += `<a href='${fileUrl}' target='_blank'><img src='${fileUrl}' alt='Image' style='max-width:120px;max-height:120px;border-radius:8px;display:block;margin-bottom:4px;'></a>`;
            } else {
                html += `<a href='${fileUrl}' target='_blank' style='display:inline-block;margin-bottom:4px;'><i class='fas fa-paperclip'></i> ${fileName}</a><br>`;
            }
        }
        html += `${msg.message || ''}`;
        if (msg.edited_at) html += " <small>(edited)</small>";
        html += `<div class='bubble-meta'>${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}`;
        // Read receipt
        if (isSent) {
            if (selectedGroup) {
                html += ` <span title='Delivered' style='color:#28a745'>&#10003;</span>`;
            } else if (msg.is_read) {
                html += ` <span title='Read' style='color:#28a745'>&#10003;</span>`;
            } else {
                html += ` <span title='Delivered' style='color:#aaa'>&#10003;</span>`;
            }
        }
        html += `</div>`;
        if (isSent) {
            html += `<div class='bubble-actions-dropdown'>`;
            html += `<button class='bubble-menu-btn' id='bubble-btn-${msg.id}' title='More options' onclick='toggleBubbleMenu(event, ${msg.id})' aria-label='More options' aria-expanded='false' aria-controls='bubble-menu-${msg.id}'><span class='chevron'>&#8250;</span></button>`;
            html += `<div class='bubble-dropdown-menu' id='bubble-menu-${msg.id}'>`;
            html += `<button onclick='replyMessage(${msg.id})'><i class='fas fa-reply me-2'></i> Reply</button>`;
            html += `<button onclick='copyMessage(${msg.id})'><i class='fas fa-copy me-2'></i> Copy</button>`;
            html += `<button onclick='forwardMessage(${msg.id})'><i class='fas fa-share me-2'></i> Forward</button>`;
            html += `<button onclick='starMessage(${msg.id})'><i class='fas fa-star me-2'></i> Star</button>`;
            html += `<button onclick='pinMessage(${msg.id})'><i class='fas fa-thumbtack me-2'></i> Pin</button>`;
            html += `<button onclick='selectMessage(${msg.id})'><i class='fas fa-check-square me-2'></i> Select</button>`;
            html += `<button onclick='shareMessage(${msg.id})'><i class='fas fa-share-alt me-2'></i> Share</button>`;
            html += `<button onclick='infoMessage(${msg.id})'><i class='fas fa-info-circle me-2'></i> Info</button>`;
            html += `<button onclick='deleteMessage(${msg.id})'><i class='fas fa-trash-alt me-2'></i> Delete</button>`;
            html += `<button onclick='editMessage(${msg.id}, \"${msg.message?.replace(/"/g, '\\"')}\")'><i class='fas fa-pencil-alt me-2'></i> Edit</button>`;
            html += `</div></div>`;
        }
        html += `</div>`;
        html += `</div>`;
        return html;
    }

    document.querySelectorAll('.user-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.user-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            selectedUserId = this.dataset.userId;
            selectedUserName = this.dataset.userName;
            selectedGroup = (selectedUserId === 'group') ? 'Group' : null;
            document.getElementById('receiver_id').value = selectedGroup ? '' : selectedUserId;
            // Show chat header
            document.getElementById('chat-header').style.display = '';
            document.getElementById('chat-user-avatar').innerText = selectedUserName.charAt(0).toUpperCase();
            document.getElementById('chat-user-name').innerText = selectedUserName;
            document.getElementById('chat-search').style.display = '';
            fetchMessages(selectedUserId);
        });
    });

    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();
        if (!selectedUserId) return alert('Select a user to chat with.');
        const formData = new FormData(this);
        if (window.replyToMsgId) {
            formData.append('reply_to', window.replyToMsgId);
        }
        if (selectedGroup) formData.append('group', selectedGroup);
        axios.post('/chat/messages', formData).then(res => {
            fetchMessages(selectedUserId);
            this.reset();
            hideReplyBar();
        });
    });

    window.deleteMessage = function(id) {
        if (confirm('Delete this message?')) {
            axios.delete(`/chat/messages/${id}`).then(() => fetchMessages(selectedUserId));
        }
    }

    window.editMessage = function(id, text) {
        const newText = prompt('Edit your message:', text);
        if (newText !== null) {
            axios.put(`/chat/messages/${id}`, { message: newText }).then(() => fetchMessages(selectedUserId));
        }
    }

    // Emoji picker
    const emojiBtn = document.getElementById('emoji-btn');
    const emojiPicker = document.getElementById('emoji-picker');
    emojiBtn.addEventListener('click', function(e) {
        e.preventDefault();
        emojiPicker.style.display = emojiPicker.style.display === 'none' ? 'block' : 'none';
        if (emojiPicker.childElementCount === 0) {
            const picker = document.createElement('emoji-picker');
            picker.addEventListener('emoji-click', event => {
                document.getElementById('message-input').value += event.detail.unicode;
                emojiPicker.style.display = 'none';
            });
            emojiPicker.appendChild(picker);
        }
    });

    // File input label
    document.querySelector('.file-label').addEventListener('click', function() {
        document.getElementById('file-input').click();
    });

    // Typing indicator
    const messageInput = document.getElementById('message-input');
    let typingTimeout;
    messageInput.addEventListener('input', function() {
        if (!selectedUserId) return;
        axios.post('/chat/typing', { receiver_id: selectedUserId });
    });

    // Listen for typing events
    if (window.Echo) {
        window.Echo.private('chat.' + userId)
            .listen('MessageSent', (e) => {
                if (selectedUserId == e.sender_id) {
                    fetchMessages(selectedUserId);
                }
            })
            .listen('UserTyping', (e) => {
                if (selectedUserId == e.sender_id) {
                    const indicator = document.getElementById('typing-indicator');
                    indicator.innerText = 'Typing...';
                    indicator.style.display = '';
                    clearTimeout(typingTimeout);
                    typingTimeout = setTimeout(() => {
                        indicator.style.display = 'none';
                    }, 1500);
                }
            });
    }

    // Chat search
    document.getElementById('chat-search').addEventListener('input', function() {
        const val = this.value.toLowerCase();
        const filtered = allMessages.filter(msg => {
            const text = (msg.message || '').toLowerCase();
            const file = (msg.file || '').toLowerCase();
            return text.includes(val) || file.includes(val);
        });
        renderMessages(filtered);
    });

    // User profile popover
    document.querySelectorAll('.user-info-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const userItem = this.closest('.user-item');
            document.getElementById('profile-avatar').innerText = userItem.dataset.userName.charAt(0).toUpperCase();
            document.getElementById('profile-name').innerText = userItem.dataset.userName;
            document.getElementById('profile-email').innerText = userItem.dataset.userEmail;
            document.getElementById('profile-role').innerText = userItem.dataset.userRole ? userItem.dataset.userRole.charAt(0).toUpperCase() + userItem.dataset.userRole.slice(1) : '';
            const modal = new bootstrap.Modal(document.getElementById('userProfileModal'));
            modal.show();
        });
    });

    // Theme toggle
    const themeToggle = document.getElementById('theme-toggle');
    function setTheme(dark) {
        if (dark) {
            document.body.classList.add('dark-mode');
            themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            localStorage.setItem('theme', 'dark');
        } else {
            document.body.classList.remove('dark-mode');
            themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            localStorage.setItem('theme', 'light');
        }
    }
    themeToggle.addEventListener('click', function() {
        setTheme(!document.body.classList.contains('dark-mode'));
    });
    // On load
    setTheme(localStorage.getItem('theme') === 'dark');

    // Tap to show actions on mobile
    document.addEventListener('click', function(e) {
        document.querySelectorAll('.chat-bubble.sent').forEach(bubble => {
            bubble.classList.remove('show-actions');
        });
        if (e.target.closest('.chat-bubble.sent')) {
            e.target.closest('.chat-bubble.sent').classList.add('show-actions');
        }
    });

    // Tap/click to show chevron for only the tapped message
    document.addEventListener('click', function(e) {
        document.querySelectorAll('.chat-bubble.sent').forEach(bubble => {
            bubble.classList.remove('show-chevron');
        });
        document.querySelectorAll('.bubble-dropdown-menu').forEach(menu => menu.classList.remove('show'));
        document.querySelectorAll('.bubble-menu-btn').forEach(btn => btn.classList.remove('open'));
        const clicked = e.target.closest('.chat-bubble.sent');
        if (clicked && !e.target.closest('.bubble-menu-btn')) {
            clicked.classList.add('show-chevron');
        }
    });
    window.toggleBubbleMenu = function(e, msgId) {
        e.stopPropagation();
        document.querySelectorAll('.bubble-dropdown-menu').forEach(menu => menu.classList.remove('show'));
        document.querySelectorAll('.bubble-menu-btn').forEach(btn => btn.classList.remove('open'));
        const menu = document.getElementById('bubble-menu-' + msgId);
        const btn = document.getElementById('bubble-btn-' + msgId);
        if (menu) {
            menu.classList.toggle('show');
            if (btn) btn.classList.toggle('open');
        }
    };

    // Reply logic
    window.replyToMsgId = null;
    window.replyMessage = function(id) {
        // Find the message in allMessages
        const msg = allMessages.find(m => m.id == id);
        if (!msg) return;
        window.replyToMsgId = id;
        document.getElementById('reply-bar').style.display = '';
        document.getElementById('reply-author').innerText = (msg.sender_id == userId ? 'You: ' : (msg.sender_name || 'User') + ': ');
        let preview = msg.message ? msg.message.substring(0, 40) : '[file]';
        document.getElementById('reply-preview').innerText = preview;
        document.getElementById('message-input').focus();
    };
    function hideReplyBar() {
        window.replyToMsgId = null;
        document.getElementById('reply-bar').style.display = 'none';
        document.getElementById('reply-author').innerText = '';
        document.getElementById('reply-preview').innerText = '';
    }
    document.getElementById('cancel-reply-btn').addEventListener('click', hideReplyBar);

    // Add placeholder JS functions for new actions
    window.copyMessage = function(id) { alert('Copy message ' + id); };
    window.forwardMessage = function(id) { alert('Forward message ' + id); };
    window.starMessage = function(id) { alert('Star message ' + id); };
    window.pinMessage = function(id) { alert('Pin message ' + id); };
    window.selectMessage = function(id) { alert('Select message ' + id); };
    window.shareMessage = function(id) { alert('Share message ' + id); };
    window.infoMessage = function(id) { alert('Info for message ' + id); };

    // Add scrollToMessage JS
    window.scrollToMessage = function(id) {
        const el = document.querySelector(`.chat-bubble[data-msg-id='${id}']`);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            el.classList.add('highlight-reply');
            setTimeout(() => el.classList.remove('highlight-reply'), 1200);
        }
    };
    // Add highlight style
    const style = document.createElement('style');
    style.innerHTML = `.highlight-reply { box-shadow: 0 0 0 3px var(--gold); background: #fffbe6 !important; transition: box-shadow 0.2s, background 0.2s; }`;
    document.head.appendChild(style);
</script>
@endpush 
@extends('layouts.admin')
@section('title', 'Chat')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card wine-card border-0 shadow-sm">
                <div class="card-header bg-burgundy text-gold d-flex align-items-center" style="border-radius: 1rem 1rem 0 0;">
                    <i class="fas fa-wine-bottle fa-lg me-2"></i>
                    <h4 class="mb-0 flex-grow-1">Start a Chat</h4>
                    <small class="text-gold ms-2">
                        {{ auth()->user()->role === 'Customer' ? 'Available Suppliers' : 'Available Customers' }}
                    </small>
                </div>
                <div class="card-body bg-cream" style="border-radius: 0 0 1rem 1rem;">
                    @forelse($users as $user)
                        <div class="d-flex justify-content-between align-items-center p-3 mb-2 rounded wine-list-item" style="background: var(--cream); border: 1px solid var(--gold);">
                            <div>
                                <h6 class="mb-1 text-burgundy">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <a href="{{ route('chat.show', $user->id) }}" class="btn btn-gold btn-sm shadow-sm">
                                <i class="fas fa-comment"></i> Start Chat
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-burgundy mb-3"></i>
                            <p class="text-muted">No {{ auth()->user()->role === 'Customer' ? 'suppliers' : 'customers' }} available to chat with.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
<style>
.bg-burgundy { background-color: #5e0f0f !important; }
.bg-cream { background-color: #f5f0e6 !important; }
.text-burgundy { color: #5e0f0f !important; }
.text-gold { color: #c8a97e !important; }
.btn-gold { background-color: #c8a97e; color: #5e0f0f; border: none; }
.btn-gold:hover { background-color: #b8945f; color: #fff; }
.wine-card { border-radius: 1rem; }
.wine-list-item { transition: background 0.2s; }
.wine-list-item:hover { background: #f5e6d0; }
</style>
@endpush
@endsection 