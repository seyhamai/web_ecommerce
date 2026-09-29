@props([
    'id', 
    'active' => false // True if this pane should be visible by default
])

<div class="tab-pane fade {{ $active ? 'show active' : '' }}" id="{{ $id }}" role="tabpanel">
    {{ $slot }}
</div>