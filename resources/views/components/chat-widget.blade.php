@php
    $user = Auth::user();
    $canChat = $user && in_array($user->role, ['Admin','Wholesaler','Customer','Retailer','Vendor','Supplier']);
@endphp
@if($canChat)
<!-- Floating Chat Button -->
<a href="{{ route('chat.index') }}" id="floating-chat-btn" style="position:fixed;bottom:32px;right:32px;z-index:9999;" title="Open Chat">
    <button type="button" class="btn btn-burgundy rounded-circle shadow-lg" style="width:64px;height:64px;font-size:2rem;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-comments"></i>
    </button>
</a>
<style>
#floating-chat-btn .btn-burgundy {
    background: var(--burgundy,#5e0f0f);
    color: #fff;
    border: 2px solid var(--gold,#c8a97e);
    box-shadow: 0 4px 24px rgba(94,15,15,0.13);
    transition: background 0.2s, color 0.2s;
}
#floating-chat-btn .btn-burgundy:hover {
    background: var(--gold,#c8a97e);
    color: var(--burgundy,#5e0f0f);
}
@media (max-width: 600px) {
    #floating-chat-btn { right: 12px; bottom: 12px; }
    #floating-chat-btn .btn-burgundy { width:48px;height:48px;font-size:1.4rem; }
}
</style>
@endif 