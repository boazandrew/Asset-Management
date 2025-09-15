@php
$isEdit = isset($asset);
$isAssigned = $isEdit && $asset->status === 'Assigned';
$isVendorReturned = $isEdit && $asset->status === 'Returned to vendor';
@endphp

<form action="{{ $isEdit ? route('admin.assets.update', $asset->id) : route('admin.assets.store') }}" method="POST" class="space-y-4">
    @csrf
    @if($isEdit)
    @method('PUT')
    @endif
    <div class="row g-3">
        <!-- Serial display (readonly) -->
        <div class="col-12">
            <label class="form-label fw-semibold">NRG Serial Number</label>
            <input type="text"
                value="{{ $isEdit ? $asset->nrg_serial_number : (\App\Models\Asset::max('nrg_serial_number') ? 'NRG_' . str_pad(((int) str_replace('NRG_', '', \App\Models\Asset::max('nrg_serial_number'))) + 1, 3, '0', STR_PAD_LEFT) : 'NRG_001') }}"
                readonly
                class="form-control bg-light" />
        </div>

        <!-- Name -->
        <div class="col-md-6 col-12">
            <label class="form-label fw-semibold">Asset Name</label>
            <input name="name" value="{{ old('name', $asset->name ?? '') }}" type="text"
                class="form-control"
                {{ $isVendorReturned ? 'disabled' : '' }} required>
        </div>

        <!-- Brand -->
        <div class="col-md-6 col-12">
            <label class="form-label fw-semibold">Brand</label>
            <input name="brand" value="{{ old('brand', $asset->brand ?? '') }}" type="text"
                class="form-control"
                {{ $isVendorReturned ? 'disabled' : '' }} required>
        </div>

        <!-- Specification -->
        <div class="col-12">
            <label class="form-label fw-semibold">Specification</label>
            <textarea name="specification" rows="3"
                class="form-control"
                {{ $isVendorReturned ? 'disabled' : '' }} required>{{ old('specification', $asset->specification ?? '') }}</textarea>
        </div>

        <!-- Category -->
        <div class="col-md-6 col-12">
            <label class="form-label fw-semibold">Category</label>
            <select name="category"
                class="form-select"
                {{ $isVendorReturned ? 'disabled' : '' }} required>
                <option value="">Select Category</option>
                @foreach(['Laptop','Monitor','Mouse','Keyboard','Others'] as $cat)
                <option value="{{ $cat }}" {{ old('category', $asset->category ?? '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <!-- Handling Type -->
        <div class="col-md-6 col-12">
            <label class="form-label fw-semibold">Handling Type</label>
            <select name="handling_type"
                class="form-select"
                {{ $isVendorReturned ? 'disabled' : '' }} required>
                <option value="">Select Handling Type</option>
                @foreach(['Returnable','Non-returnable','Consumable'] as $type)
                <option value="{{ $type }}" {{ old('handling_type', $asset->handling_type ?? '') == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <!-- Vendor -->
        <div class="col-md-6 col-12">
            <label class="form-label fw-semibold">Vendor</label>
            <select name="vendor_id"
                class="form-select"
                {{ $isVendorReturned ? 'disabled' : '' }} required>
                <option value="">Select Vendor</option>
                @foreach($vendors as $vendor)
                <option value="{{ $vendor->id }}" {{ old('vendor_id', $asset->vendor_id ?? '') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Procurement Date -->
        <div class="col-md-6 col-12">
            <label class="form-label fw-semibold">Procurement Date</label>
            <input name="procurement_date" type="date"
                value="{{ old('procurement_date', isset($asset) ? $asset->procurement_date->format('Y-m-d') : '') }}"
                class="form-control"
                {{ $isVendorReturned ? 'disabled' : '' }} required>
        </div>

        <!-- Status: only show on edit -->
        @if($isEdit)
        <div class="col-12">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select"
                {{ ($isAssigned || $isVendorReturned) ? 'disabled' : '' }} required>
                @foreach(['Unassigned','Assigned','Returned to vendor'] as $status)
                <option value="{{ $status }}" {{ old('status', $asset->status ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>

            @if($isAssigned || $isVendorReturned)
            <!-- hidden input so status still submits -->
            <input type="hidden" name="status" value="{{ $asset->status }}">
            <div class="form-text">
                @if($isAssigned) Status locked while assigned to a user. @endif
                @if($isVendorReturned) Asset returned to vendor — editing disabled. @endif
            </div>
            @endif
        </div>
        @else
        <!-- Hidden default for create -->
        <input type="hidden" name="status" value="Unassigned" />
        @endif

        <!-- Buttons -->
        <div class="col-12 d-grid">
            <button type="submit" class="btn btn-primary">
                {{ $isEdit ? 'Update Asset' : 'Save Asset' }}
            </button>
        </div>
    </div>
</form>