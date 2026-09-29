@props([
    'id',               // Required: The ID to trigger the modal (e.g., 'createCategoryModal')
    'title',            // Required: The text in the header
    'formAction' => '', // Optional: If provided, wraps the body in a form
    'formMethod' => 'POST',
    'submitText' => 'Save Changes',
    'submitColor' => 'primary', // e.g., 'success', 'primary', 'danger'
])

<div {{ $attributes->merge(['class' => 'modal fade']) }} id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            @if($formAction)
                <!-- If formAction is provided, wrap the content in a form -->
                <form action="{{ $formAction }}" method="POST" id="{{ $id }}Form">
                    @csrf
                    @if(strtoupper($formMethod) !== 'POST')
                        @method($formMethod)
                    @endif
                    
                    <div class="modal-body">
                        {{ $slot }}
                    </div>
                    
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-{{ $submitColor }} shadow-sm fw-bold">{{ $submitText }}</button>
                    </div>
                </form>
            @else
                <!-- If no form Action is provided, just render the content normally -->
                <div class="modal-body">
                    {{ $slot }}
                </div>
            @endif
            
        </div>
    </div>
</div>