<div class="chat-area-navbar d-flex align-items-center px-4 py-2 bg-white border-bottom" style="height: 64px; min-height: 64px;">
    @if(isset($other))
        <div class="user-avatar me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.3rem; background: var(--burgundy); color: var(--gold); border-radius: 50%; font-weight: 600;">{{ strtoupper(substr($other->name, 0, 1)) }}</div>
        <div class="d-flex flex-column justify-content-center">
            <div class="fw-bold text-burgundy" style="font-size: 1.1rem;">{{ $other->name }}</div>
            <div class="small text-muted">{{ $other->email }}</div>
        </div>
    @else
        <div class="w-100 text-center text-burgundy fw-bold" style="font-size: 1.1rem;">Chat</div>
    @endif
</div>
<div class="d-flex flex-column flex-grow-1 position-relative" style="height: calc(100vh - 48px - 64px); min-height: 300px;">
    <div class="messages-area flex-grow-1 px-4 py-3" id="messages-area" style="overflow-y: auto;">
        @if(isset($messages))
            @forelse($messages as $message)
                @include('chat._message', ['message' => $message])
            @empty
                <div class="text-center text-muted mt-4">
                    <i class="fas fa-comments fa-3x mb-3 text-burgundy"></i>
                    <p>No messages yet. Start the conversation!</p>
                </div>
            @endforelse
        @else
            <div class="text-center text-muted mt-4">
                <i class="fas fa-comments fa-3x mb-3 text-burgundy"></i>
                <p>Select a chat to start messaging.</p>
            </div>
        @endif
    </div>
    @if(isset($other))
        <form action="{{ route('chat.store', $other->id) }}" method="POST" class="send-area w-100 px-4 py-3 bg-white border-top" id="chat-form" style="position: sticky; bottom: 0;" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <button type="button" id="emoji-btn" class="btn btn-light" tabindex="-1" style="font-size:1.3em;">😊</button>
                <button type="button" id="attach-btn" class="btn btn-light" tabindex="-1" style="font-size:1.3em;">
                    <i class="fas fa-paperclip"></i>
                </button>
                <input type="file" name="attachment" id="chat-attachment" class="d-none" accept="image/*,.pdf,.doc,.docx">
                <input type="text" name="message" class="form-control wine-input" placeholder="Type your message..." maxlength="2000" id="chat-input">
                <button type="submit" class="btn btn-gold">
                    <i class="fas fa-paper-plane"></i> Send
                </button>
            </div>
            <div id="attachment-preview" class="mt-2"></div>
        </form>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.4/dist/emoji-button.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const button = document.getElementById('emoji-btn');
  const input = document.getElementById('chat-input');
  if (button && input && window.EmojiButton) {
    const picker = new EmojiButton();
    picker.on('emoji', emoji => {
      // Insert emoji at cursor position
      const start = input.selectionStart;
      const end = input.selectionEnd;
      input.value = input.value.substring(0, start) + emoji + input.value.substring(end);
      input.focus();
      input.selectionStart = input.selectionEnd = start + emoji.length;
    });
    button.addEventListener('click', () => {
      picker.togglePicker(button);
    });
  }
  const attachmentInput = document.getElementById('chat-attachment');
  const attachBtn = document.getElementById('attach-btn');
  const preview = document.getElementById('attachment-preview');
  if (attachBtn && attachmentInput) {
    attachBtn.addEventListener('click', function() {
      attachmentInput.click();
    });
  }
  if (attachmentInput && preview) {
    attachmentInput.addEventListener('change', function() {
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
    });
  }
});
</script>
<style>
.wine-bubble-me {
    background: var(--burgundy);
    color: #fff;
    border-top-right-radius: 0.5rem !important;
    border-bottom-left-radius: 1.5rem !important;
}
.wine-bubble-other {
    background: #fff;
    color: var(--burgundy);
    border: 1px solid var(--gold);
    border-top-left-radius: 0.5rem !important;
    border-bottom-right-radius: 1.5rem !important;
}
.wine-input {
    border-radius: 2rem 0 0 2rem;
    border: 1px solid var(--gold);
}
.send-area {
    background: #fff;
    border-top: 1px solid #eee;
}
.bubble-time {
    color: inherit !important;
}
</style> 