@props([
    'tabs' => [],      // Array of tab IDs and labels: ['colors' => '🎨 Manage Colors']
    'active' => null   // The ID of the tab that should be open by default
])

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white pt-3 pb-0 border-bottom-0">
        <ul class="nav nav-tabs" role="tablist">
            @foreach($tabs as $id => $label)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $active === $id ? 'active fw-bold text-primary border-bottom-0' : 'fw-bold text-secondary' }}" 
                            id="{{ $id }}-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#{{ $id }}" 
                            type="button" 
                            role="tab">
                        {!! $label !!}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="card-body bg-light rounded-bottom">
        <div class="tab-content">
            {{ $slot }}
        </div>
    </div>
</div>