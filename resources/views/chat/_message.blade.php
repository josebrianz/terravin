@if(isset($message))
<div class="mb-3 {{ $message->sender_id === auth()->id() ? 'text-end' : 'text-start' }}">
    <div class="d-inline-block p-2 rounded-3 shadow-sm wine-bubble-{{ $message->sender_id === auth()->id() ? 'me' : 'other' }} position-relative" style="max-width: 70%; min-width: 80px;">
        <div style="display: flex; flex-direction: column; align-items: flex-end;">
            <div style="width: 100%; word-break: break-word; text-align: left;">
                {{ $message->message }}
                @if($message->sender_id === auth()->id())
                    <button class="btn btn-sm btn-link text-danger p-0 ms-2 delete-message-btn" data-message-id="{{ $message->id }}" title="Delete"><i class="fas fa-trash"></i></button>
                    <button class="btn btn-sm btn-link text-primary p-0 ms-1 edit-message-btn" data-message-id="{{ $message->id }}" data-message-text="{{ $message->message }}" title="Edit"><i class="fas fa-edit"></i></button>
                @endif
            </div>
            <div class="bubble-time" style="font-size: 0.85em; margin-top: 2px; opacity: 0.8; color: inherit; align-self: flex-end; line-height: 1;">
                {{ $message->created_at->timezone(config('app.timezone'))->format('H:i') }}
            </div>
        </div>
    </div>
</div>
@endif
<style>
.bubble-time {
    color: inherit !important;
}
</style> 