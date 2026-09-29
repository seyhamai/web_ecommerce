@props([
    'type' => 'button',     // button, submit, reset
    'color' => 'primary',   // primary, success, danger, secondary, etc.
    'size' => null,         // sm, lg
    'icon' => null,         // e.g., 'fas fa-save'
    'href' => null,         // If passed, it becomes an <a> tag automatically
    'outline' => false,     // True makes it btn-outline-*
])

@php
    // Automatically build the Bootstrap class list
    $baseClass = 'btn shadow-sm fw-semibold d-inline-flex align-items-center justify-content-center';
    $colorClass = $outline ? "btn-outline-{$color}" : "btn-{$color}";
    $sizeClass = $size ? "btn-{$size}" : '';
    
    $mergedClasses = trim("{$baseClass} {$colorClass} {$sizeClass}");
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $mergedClasses]) }}>
        @if($icon) <i class="{{ $icon }} me-1"></i> @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $mergedClasses]) }}>
        @if($icon) <i class="{{ $icon }} me-1"></i> @endif
        {{ $slot }}
    </button>
@endif