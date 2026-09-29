@props([
    'title',
    'breadcrumb' => null,
    'breadcrumbUrl' => null,
])
<div>
<h1 class="mt-4 font-semibold fs-2">{{ $title }}</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
        <a href="{{ $breadcrumbUrl ? url($breadcrumbUrl) : url('/admin/dashboard') }}">
            Dashboard
        </a>
    </li>

    @if($breadcrumb)
        <li class="breadcrumb-item active">
            {{ $breadcrumb }}
        </li>
    @endif
</ol>
</div>

