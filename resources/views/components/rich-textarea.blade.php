@props([
    'name',
    'label' => false,
    'value' => '',
    'placeholder' => '',
    'rows' => 3,
    'id' => null,
])

<!-- We pass the exact props down to your standard textarea component -->
<!-- We also inject a special 'rich-editor' class so our JavaScript can find it -->
<x-textarea 
    :name="$name" 
    :label="$label" 
    :value="$value" 
    :placeholder="$placeholder" 
    :rows="$rows" 
    :id="$id" 
    {{ $attributes->merge(['class' => 'rich-editor']) }} 
/>

@once
    @push('scripts')
        <style>
            /* Ensure all rich editors have a good default height */
            .ck-editor__editable_inline {
                min-height: 150px;
            }
        </style>
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Find EVERY textarea with the 'rich-editor' class and turn it into CKEditor
                document.querySelectorAll('.rich-editor').forEach((editorElement) => {
                    ClassicEditor.create(editorElement, {
                        toolbar: [ 
                            'heading', '|', 
                            'bold', 'italic', 'underline', 'strikethrough', '|', 
                            'link', 'bulletedList', 'numberedList', 'blockQuote', '|',  
                            'undo', 'redo' 
                        ]
                    }).catch(error => {
                        console.error(error);
                    });
                });
            });
        </script>
    @endpush
@endonce