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

    <!-- Serial display (readonly) -->
    <div>
        <label class="block text-sm font-medium text-gray-700">NRG Serial Number</label>
        <input type="text"
               value="{{ $isEdit ? $asset->nrg_serial_number : (\App\Models\Asset::max('nrg_serial_number') ? \App\Models\Asset::max('nrg_serial_number') + 1 : 1) }}"
               readonly
               class="mt-1 block w-full border border-gray-300 rounded-md bg-gray-100 p-2" />
    </div>

    <!-- Name -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Asset Name</label>
        <input name="name" value="{{ old('name', $asset->name ?? '') }}" type="text"
               class="mt-1 block w-full border rounded p-2"
               {{ $isVendorReturned ? 'disabled' : '' }} required>
    </div>

    <!-- Brand -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Brand</label>
        <input name="brand" value="{{ old('brand', $asset->brand ?? '') }}" type="text"
               class="mt-1 block w-full border rounded p-2"
               {{ $isVendorReturned ? 'disabled' : '' }} required>
    </div>

    <!-- Specification -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Specification</label>
        <textarea name="specification" rows="3"
                  class="mt-1 block w-full border rounded p-2"
                  {{ $isVendorReturned ? 'disabled' : '' }} required>{{ old('specification', $asset->specification ?? '') }}</textarea>
    </div>

    <!-- Category -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Category</label>
        <select name="category"
                class="mt-1 block w-full border rounded p-2"
                {{ $isVendorReturned ? 'disabled' : '' }} required>
            <option value="">Select Category</option>
            @foreach(['Laptop','Monitor','Mouse','Keyboard','Others'] as $cat)
                <option value="{{ $cat }}" {{ old('category', $asset->category ?? '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
    </div>

    <!-- Handling Type -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Handling Type</label>
        <select name="handling_type"
                class="mt-1 block w-full border rounded p-2"
                {{ $isVendorReturned ? 'disabled' : '' }} required>
            <option value="">Select Handling Type</option>
            @foreach(['Returnable','Non-returnable','Consumable'] as $type)
                <option value="{{ $type }}" {{ old('handling_type', $asset->handling_type ?? '') == $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
        </select>
    </div>

    <!-- Vendor -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Vendor</label>
        <select name="vendor_id"
                class="mt-1 block w-full border rounded p-2"
                {{ $isVendorReturned ? 'disabled' : '' }} required>
            <option value="">Select Vendor</option>
            @foreach($vendors as $vendor)
                <option value="{{ $vendor->id }}" {{ old('vendor_id', $asset->vendor_id ?? '') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Procurement Date -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Procurement Date</label>
        <input name="procurement_date" type="date"
               value="{{ old('procurement_date', isset($asset) ? $asset->procurement_date->format('Y-m-d') : '') }}"
               class="mt-1 block w-full border rounded p-2"
               {{ $isVendorReturned ? 'disabled' : '' }} required>
    </div>

    <!-- Status: only show on edit -->
    @if($isEdit)
        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" class="mt-1 block w-full border rounded p-2"
                    {{ ($isAssigned || $isVendorReturned) ? 'disabled' : '' }} required>
                @foreach(['Unassigned','Assigned','Returned to vendor'] as $status)
                    <option value="{{ $status }}" {{ old('status', $asset->status ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>

            @if($isAssigned || $isVendorReturned)
                <!-- hidden input so status still submits -->
                <input type="hidden" name="status" value="{{ $asset->status }}">
                <p class="text-xs text-gray-500 mt-1">
                    @if($isAssigned) Status locked while assigned to a user. @endif
                    @if($isVendorReturned) Asset returned to vendor — editing disabled. @endif
                </p>
            @endif
        </div>
    @else
        <!-- Hidden default for create -->
        <input type="hidden" name="status" value="Unassigned" />
    @endif

    <!-- Buttons -->
    <div class="flex space-x-2">
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
            {{ $isEdit ? 'Update Asset' : 'Save Asset' }}
        </button>
        <button type="button" onclick="closeAssetModal()" class="w-full bg-gray-200 text-gray-800 py-2 rounded hover:bg-gray-300">Cancel</button>
    </div>
</form>
