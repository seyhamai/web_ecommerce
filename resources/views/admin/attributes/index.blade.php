@extends('layouts.admin')

@section('content')
    @php
        $activeTab = session('active_tab', 'colors');
    @endphp
    <div class="container-fluid px-1 px-md-2">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <x-page-header title="Product Attributes" breadcrumb="Attributes" breadcrumb-url="/admin/dashboard" />
        </div>

        <x-_alerts />

        <x-tabs :tabs="['colors' => '🎨 Manage Colors', 'sizes' => '📏 Manage Sizes']" active="colors">

            <x-tab-pane id="colors" :active="$activeTab === 'colors'">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <p class="mb-0 text-muted">Create and manage colors available for your products.</p>
                    <x-button type="button" color="primary" size="sm" icon="fas fa-plus" data-bs-toggle="modal"
                        data-bs-target="#addColorModal">
                        Add New Color
                    </x-button>
                </div>

                <x-table :headers="['No.', 'Color Name', 'Hex Code', 'Preview', 'Actions']">
                    @forelse($colors as $color)
                        <tr>
                            <td class="fw-bold text-muted ps-4">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $color->name }}</td>
                            <td><code>{{ $color->hex_code }}</code></td>
                            <td>
                                <span class="d-inline-block rounded-circle shadow-sm border"
                                    style="width: 24px; height: 24px; background-color: {{ $color->hex_code }};"></span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <!-- Universal Edit Button -->
                                    <x-button type="button" color="primary" outline size="sm" icon="fas fa-edit"
                                        data-bs-toggle="modal" data-bs-target="#editColorModal"
                                        data-action-url="{{ route('admin.color.update', $color->id) }}"
                                        data-input-color_name="{{ $color->name }}"
                                        data-input-hex_code="{{ $color->hex_code }}"
                                        onclick="document.getElementById('editVisualPicker').value = '{{ $color->hex_code }}'" />

                                    <!-- Universal Delete Action -->
                                    <form action="{{ route('admin.color.destroy', $color->id) }}" method="POST"
                                        class="m-0">
                                        @csrf @method('DELETE')
                                        <x-button type="submit" color="danger" outline size="sm" icon="fas fa-trash"
                                            class="requires-confirmation"
                                            data-message="Are you sure you want to delete '{{ $color->name }}'? This cannot be undone." />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No colors found. Click "Add New Color" to
                                get started.</td>
                        </tr>
                    @endforelse
                </x-table>
            </x-tab-pane>

            <x-tab-pane id="sizes" :active="$activeTab === 'sizes'">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="mb-0 text-muted">Create and manage sizes (e.g., S, M, L, 1, 2, 3, ...).</p>
                    <x-button type="button" color="primary" size="sm" icon="fas fa-plus" data-bs-toggle="modal"
                        data-bs-target="#addSizeModal">
                        Add New Size
                    </x-button>
                </div>

                <x-table :headers="['No.', 'Size Name', 'Actions']">
                    @forelse($sizes as $size)
                        <tr>
                            <td class="fw-bold text-muted ps-4">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $size->name }}</td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-2 justify-content-end">

                                    <x-button type="button" color="primary" outline size="sm" icon="fas fa-edit"
                                        data-bs-toggle="modal" data-bs-target="#editSizeModal"
                                        data-action-url="{{ route('admin.size.update', $size->id) }}"
                                        data-input-size_name="{{ $size->name }}" />

                                    <form action="{{ route('admin.size.destroy', $size->id) }}" method="POST"
                                        class="m-0">
                                        @csrf @method('DELETE')
                                        <x-button type="submit" color="danger" outline size="sm" icon="fas fa-trash"
                                            class="requires-confirmation"
                                            data-message="Are you sure you want to delete '{{ $size->name }}'?" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">No sizes found. Click "Add New Size" to
                                get started.</td>
                        </tr>
                    @endforelse
                </x-table>
            </x-tab-pane>

        </x-tabs>
    </div>
    <x-modal id="addColorModal" class="{{ $errors->any() && old('hex_code') ? 'has-validation-error' : '' }}"
        title="Add New Color" form-action="{{ route('admin.color.store') }}" submit-color="primary"
        submit-text="Save Color">
        <x-input name="color_name" label="Color Name" placeholder="e.g. Navy Blue" :value="old('hex_code') ? old('name') : ''" required />

        <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Quick Presets (12 Popular Colors)</label>
            <div class="d-flex flex-wrap gap-2 p-2 bg-light rounded border">
                <button type="button" class="btn p-0 border shadow-sm rounded-circle"
                    style="width: 30px; height: 30px; background-color: #000000;" onclick="selectPreset('#000000', 'Black')"
                    title="Black"></button>
                <button type="button" class="btn p-0 border shadow-sm rounded-circle"
                    style="width: 30px; height: 30px; background-color: #FFFFFF;" onclick="selectPreset('#FFFFFF', 'White')"
                    title="White"></button>
                <button type="button" class="btn p-0 border shadow-sm rounded-circle"
                    style="width: 30px; height: 30px; background-color: #808080;"
                    onclick="selectPreset('#808080', 'Gray')" title="Gray"></button>
                <button type="button" class="btn p-0 border shadow-sm rounded-circle"
                    style="width: 30px; height: 30px; background-color: #FF0000;" onclick="selectPreset('#FF0000', 'Red')"
                    title="Red"></button>
                <button type="button" class="btn p-0 border shadow-sm rounded-circle"
                    style="width: 30px; height: 30px; background-color: #FFA500;"
                    onclick="selectPreset('#FFA500', 'Orange')" title="Orange"></button>
                <button type="button" class="btn p-0 border shadow-sm rounded-circle"
                    style="width: 30px; height: 30px; background-color: #FFFF00;"
                    onclick="selectPreset('#FFFF00', 'Yellow')" title="Yellow"></button>
                <button type="button" class="btn p-0 border shadow-sm rounded-circle"
                    style="width: 30px; height: 30px; background-color: #008000;"
                    onclick="selectPreset('#008000', 'Green')" title="Green"></button>
                <button type="button" class="btn p-0 border shadow-sm rounded-circle"
                    style="width: 30px; height: 30px; background-color: #000080;"
                    onclick="selectPreset('#000080', 'Navy')" title="Navy"></button>
                <button type="button" class="btn p-0 border shadow-sm rounded-circle"
                    style="width: 30px; height: 30px; background-color: #0000FF;"
                    onclick="selectPreset('#0000FF', 'Blue')" title="Blue"></button>
                <button type="button" class="btn p-0 border shadow-sm rounded-circle"
                    style="width: 30px; height: 30px; background-color: #800080;"
                    onclick="selectPreset('#800080', 'Purple')" title="Purple"></button>
                <button type="button" class="btn p-0 border shadow-sm rounded-circle"
                    style="width: 30px; height: 30px; background-color: #FFC0CB;"
                    onclick="selectPreset('#FFC0CB', 'Pink')" title="Pink"></button>
                <button type="button" class="btn p-0 border shadow-sm rounded-circle"
                    style="width: 30px; height: 30px; background-color: #A52A2A;"
                    onclick="selectPreset('#A52A2A', 'Brown')" title="Brown"></button>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Hex Code</label>
            <div class="input-group">
                <input type="color" id="addVisualPicker" class="form-control form-control-color"
                    value="{{ old('hex_code', '#000000') }}" style="max-width: 60px;"
                    oninput="document.getElementById('addHexInput').value = this.value">
                <input type="text" id="addHexInput" name="hex_code"
                    class="form-control @error('hex_code') is-invalid @enderror" value="{{ old('hex_code', '#000000') }}"
                    required oninput="document.getElementById('addVisualPicker').value = this.value">
            </div>
        </div>
    </x-modal>

    <x-modal id="editColorModal" title="Edit Color" form-action="#" form-method="PUT" submit-color="blue"
        submit-text="Update Color">
        <x-input name="color_name" label="Color Name" required />

        <div class="mb-3">
            <label class="form-label fw-semibold">Hex Code</label>
            <div class="input-group">
                <input type="color" id="editVisualPicker" class="form-control form-control-color"
                    style="max-width: 60px;" oninput="document.getElementById('editHexInput').value = this.value">
                <input type="text" id="editHexInput" name="hex_code" class="form-control" required
                    oninput="document.getElementById('editVisualPicker').value = this.value">
            </div>
        </div>
    </x-modal>
    <x-modal id="addSizeModal" class="{{ $errors->any() && !old('hex_code') ? 'has-validation-error' : '' }}"
        title="Add New Size" form-action="{{ route('admin.size.store') }}" submit-color="primary"
        submit-text="Save Size">
        <x-input name="size_name" label="Size Name" placeholder="e.g. Extra Large (XL)" :value="!old('hex_code') ? old('name') : ''" required />
    </x-modal>

    <x-modal id="editSizeModal" title="Edit Size" form-action="#" form-method="PUT" submit-color="blue"
        submit-text="Update Size">
        <x-input name="size_name" label="Size Name" required />
    </x-modal>

    <script src="{{ asset('js/modules/attributeTabs.js') }}"></script>
@endsection
