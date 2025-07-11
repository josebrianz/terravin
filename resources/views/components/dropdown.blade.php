@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 wine-dropdown-bg'])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$width = match ($width) {
    '48' => 'w-48',
    default => $width,
};
@endphp

<style>
    .wine-dropdown-bg {
        background: rgba(255,255,255,0.97) !important;
        color: #7b2230 !important;
        box-shadow: 0 8px 32px 0 rgba(123,34,48,0.10);
        border: 1px solid #f8e7d1;
    }
    .wine-dropdown-bg a, .wine-dropdown-bg button, .wine-dropdown-bg span, .wine-dropdown-bg div {
        color: #7b2230 !important;
    }
    .wine-dropdown-bg a:hover, .wine-dropdown-bg button:hover {
        background: #f8e7d1 !important;
        color: #b85c38 !important;
    }
</style>
<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}"
            style="display: none;"
            @click="open = false">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
