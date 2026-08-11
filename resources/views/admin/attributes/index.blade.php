@extends('layouts.admin') <!-- Change this to match your main layout file -->

@section('content')
<div class="container-fluid px-1 px-md-2 mb-5">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="font-semibold fs-2 mb-0">Product Attributes</h1>
    </div>

    <!-- Alert Messages (Success/Error) -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0">
        <div class="card-header bg-white pt-2 pb-0 border-bottom-0">
            <!-- TABS NAVIGATION -->
            <ul class="nav nav-tabs" id="attributeTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold text-primary" id="colors-tab" data-bs-toggle="tab" data-bs-target="#colors" type="button" role="tab">🎨 Manage Colors</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold text-secondary" id="sizes-tab" data-bs-toggle="tab" data-bs-target="#sizes" type="button" role="tab">📏 Manage Sizes</button>
                </li>
            </ul>
        </div>
        
        <div class="card-body bg-light">
            <div class="tab-content" id="attributeTabsContent">
                
              
                <div class="tab-pane fade show active" id="colors" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="mb-0 text-muted">Create and manage colors available for your products.</p>
                        <!-- Button triggers Add Color Modal -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addColorModal">
                            <i class="fas fa-plus me-1"></i> Add New Color
                        </button>
                    </div>
                    
                    <div class="table-responsive bg-white rounded">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 80px;">ID</th>
                                    <th>Color Name</th>
                                    <th>Hex Code</th>
                                    <th>Preview</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($colors as $color)
                                <tr>
                                    <td>{{ $color->id }}</td>
                                    <td class="fw-semibold">{{ $color->name }}</td>
                                    <td><code>{{ $color->hex_code }}</code></td>
                                    <td>
                                        <span class="d-inline-block rounded-circle shadow-sm border" style="width: 24px; height: 24px; background-color: {{ $color->hex_code }};"></span>
                                    </td>
                                    <td class="text-end">
                                        <!-- Edit/Delete buttons (You can add routes later) -->
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No colors found. Click "Add New Color" to get started.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="sizes" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="mb-0 text-muted">Create and manage sizes (e.g., S, M, L, 1, 2, 3, ...).</p>
                        <!-- Button triggers Add Size Modal -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addSizeModal">
                            <i class="fas fa-plus me-1"></i> Add New Size
                        </button>
                    </div>

                    <div class="table-responsive bg-white rounded">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 80px;">ID</th>
                                    <th>Size Name</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sizes as $size)
                                <tr>
                                    <td>{{ $size->id }}</td>
                                    <td class="fw-semibold">{{ $size->name }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No sizes found. Click "Add New Size" to get started.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ========================== -->
<!-- MODALS FOR ADDING DATA     -->
<!-- ========================== -->

<!-- Add Color Modal -->
<div class="modal fade" id="addColorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.color.store') }}" method="POST" class="modal-content border-0 shadow">
            @csrf
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">Add New Color</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <!-- Color Name -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Color Name</label>
                    <input type="text" name="name" id="colorNameInput" class="form-control" placeholder="e.g. Navy Blue" required>
                </div>

                <!-- 12 Standard E-commerce Color Presets -->
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">Quick Presets (12 Popular Colors)</label>
                    <div class="d-flex flex-wrap gap-2 p-2 bg-light rounded border">
                        <button type="button" class="btn p-0 border shadow-sm rounded-circle" style="width: 30px; height: 30px; background-color: #000000;" onclick="selectPreset('#000000', 'Black')" title="Black"></button>
                        <button type="button" class="btn p-0 border shadow-sm rounded-circle" style="width: 30px; height: 30px; background-color: #FFFFFF;" onclick="selectPreset('#FFFFFF', 'White')" title="White"></button>
                        <button type="button" class="btn p-0 border shadow-sm rounded-circle" style="width: 30px; height: 30px; background-color: #808080;" onclick="selectPreset('#808080', 'Gray')" title="Gray"></button>
                        <button type="button" class="btn p-0 border shadow-sm rounded-circle" style="width: 30px; height: 30px; background-color: #FF0000;" onclick="selectPreset('#FF0000', 'Red')" title="Red"></button>
                        <button type="button" class="btn p-0 border shadow-sm rounded-circle" style="width: 30px; height: 30px; background-color: #FFA500;" onclick="selectPreset('#FFA500', 'Orange')" title="Orange"></button>
                        <button type="button" class="btn p-0 border shadow-sm rounded-circle" style="width: 30px; height: 30px; background-color: #FFFF00;" onclick="selectPreset('#FFFF00', 'Yellow')" title="Yellow"></button>
                        <button type="button" class="btn p-0 border shadow-sm rounded-circle" style="width: 30px; height: 30px; background-color: #008000;" onclick="selectPreset('#008000', 'Green')" title="Green"></button>
                        <button type="button" class="btn p-0 border shadow-sm rounded-circle" style="width: 30px; height: 30px; background-color: #000080;" onclick="selectPreset('#000080', 'Navy')" title="Navy"></button>
                        <button type="button" class="btn p-0 border shadow-sm rounded-circle" style="width: 30px; height: 30px; background-color: #0000FF;" onclick="selectPreset('#0000FF', 'Blue')" title="Blue"></button>
                        <button type="button" class="btn p-0 border shadow-sm rounded-circle" style="width: 30px; height: 30px; background-color: #800080;" onclick="selectPreset('#800080', 'Purple')" title="Purple"></button>
                        <button type="button" class="btn p-0 border shadow-sm rounded-circle" style="width: 30px; height: 30px; background-color: #FFC0CB;" onclick="selectPreset('#FFC0CB', 'Pink')" title="Pink"></button>
                        <button type="button" class="btn p-0 border shadow-sm rounded-circle" style="width: 30px; height: 30px; background-color: #A52A2A;" onclick="selectPreset('#A52A2A', 'Brown')" title="Brown"></button>
                    </div>
                </div>

                <!-- Hex Code Input + Visual Picker Combined -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Hex Code</label>
                    <div class="input-group">
                        <input type="color" id="visualPicker" class="form-control form-control-color" value="#000000" style="max-width: 60px;" oninput="document.getElementById('hexTextInput').value = this.value">
                        <input type="text" id="hexTextInput" name="hex_code" class="form-control" value="#000000" placeholder="#000000" required oninput="document.getElementById('visualPicker').value = this.value">
                    </div>
                    <div class="form-text text-muted">Click any preset above, or use the custom picker.</div>
                </div>

            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Color</button>
            </div>
        </form>
    </div>
</div>

<script>
    function selectPreset(hex, name) {
        document.getElementById('hexTextInput').value = hex;
        document.getElementById('visualPicker').value = hex;
        const nameInput = document.getElementById('colorNameInput');
        if(!nameInput.value) {
            nameInput.value = name;
        }
    }
</script>

<script>
    function selectPreset(hex, name) {
        document.getElementById('hexTextInput').value = hex;
        document.getElementById('visualPicker').value = hex;
        // Optionally auto-fill the name if it's empty
        const nameInput = document.getElementById('colorNameInput');
        if(!nameInput.value) {
            nameInput.value = name;
        }
    }
</script>

<!-- Add Size Modal -->
<div class="modal fade" id="addSizeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.size.store') }}" method="POST" class="modal-content border-0 shadow">
            @csrf
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">Add New Size</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Size Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Extra Large (XL)" required>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Size</button>
            </div>
        </form>
    </div>
</div>

<!-- Script to handle Tab color changes nicely -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const colorsTab = document.getElementById('colors-tab');
        const sizesTab = document.getElementById('sizes-tab');

        colorsTab.addEventListener('click', function() {
            colorsTab.classList.replace('text-secondary', 'text-primary');
            sizesTab.classList.replace('text-primary', 'text-secondary');
        });

        sizesTab.addEventListener('click', function() {
            sizesTab.classList.replace('text-secondary', 'text-primary');
            colorsTab.classList.replace('text-primary', 'text-secondary');
        });
    });
</script>
@endsection