@extends('layouts.admin')
@section('title', 'Chat with ' . $other->name)
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card wine-card border-0 shadow-sm">
                <div class="card-header bg-burgundy text-gold d-flex justify-content-between align-items-center" style="border-radius: 1rem 1rem 0 0;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-wine-glass-alt fa-lg me-2"></i>
                        <h4 class="mb-0">Chat with {{ $other->name }}</h4>
                    </div>
                    <a href="{{ route('chat.index') }}" class="btn btn-outline-gold btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body bg-cream" style="height: 400px; overflow-y: auto; border-radius: 0 0 1rem 1rem;">
                    @forelse($messages as $message)
                        <div class="mb-3 {{ $message->sender_id === auth()->id() ? 'text-end' : 'text-start' }}">
                            <div class="d-inline-block p-2 rounded-3 shadow-sm wine-bubble-{{ $message->sender_id === auth()->id() ? 'me' : 'other' }}" style="max-width: 70%;">
                                <div class="small text-muted mb-1">
                                    {{ $message->sender->name }} - {{ $message->created_at->format('M d, Y H:i') }}
                                </div>
                                <div>{{ $message->message }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted mt-4">
                            <i class="fas fa-comments fa-3x mb-3 text-burgundy"></i>
                            <p>No messages yet. Start the conversation!</p>
                        </div>
                    @endforelse
                </div>
                <div class="card-footer bg-cream" style="border-radius: 0 0 1rem 1rem;">
                    <form action="{{ route('chat.store', $other->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" class="form-control wine-input" placeholder="Type your message..." required maxlength="2000">
                            <button type="submit" class="btn btn-gold">
                                <i class="fas fa-paper-plane"></i> Send
                            </button>
                        </div>
                    </form>
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
.btn-gold:hover, .btn-outline-gold:hover { background-color: #b8945f; color: #fff; }
.btn-outline-gold { border: 1px solid #c8a97e; color: #c8a97e; background: transparent; }
.btn-outline-gold:hover { background: #c8a97e; color: #5e0f0f; }
.wine-card { border-radius: 1rem; }
.wine-bubble-me { background: #5e0f0f; color: #fff; border-top-right-radius: 0.5rem !important; border-bottom-left-radius: 1.5rem !important; }
.wine-bubble-other { background: #fff; color: #5e0f0f; border: 1px solid #c8a97e; border-top-left-radius: 0.5rem !important; border-bottom-right-radius: 1.5rem !important; }
.wine-input { border-radius: 2rem 0 0 2rem; border: 1px solid #c8a97e; }
</style>
@endpush
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageContainer = document.querySelector('.card-body');
    messageContainer.scrollTop = messageContainer.scrollHeight;
});
</script>
@endsection 