@props([
    'status' => null, 
    'name' => 'is_active',
    'label' => 'Visibility'
])

<div class="mb-4">
    <label class="form-label fw-bold d-block">{{ $label }}</label>
    <div class="d-flex gap-4 mt-2">
        <div class="form-check">
            <input class="form-check-input border-secondary" type="radio" name="{{ $name }}" id="{{ $name }}_public" value="1" 
                   {{ $status === 1 || $status === true || $status === null ? 'checked' : '' }}>
            <label class="form-check-label text-success fw-semibold" for="{{ $name }}_public">
                <i class="fas fa-globe-americas me-1"></i> Public
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input border-secondary" type="radio" name="{{ $name }}" id="{{ $name }}_hidden" value="0" 
                   {{ $status === 0 || $status === false ? 'checked' : '' }}>
            <label class="form-check-label text-muted fw-semibold" for="{{ $name }}_hidden">
                <i class="fas fa-eye-slash me-1"></i> Hidden
            </label>
        </div>
    </div>
</div>