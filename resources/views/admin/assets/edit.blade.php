@extends('layouts.app')

@section('title', 'Edit Asset - Asset Management System')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Edit Asset</h2>

    @if($asset->status === 'Returned to vendor')
        <div class="mb-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700">
            This asset has been returned to vendor. Editing is disabled.
        </div>
    @endif

    <form action="{{ route('admin.assets.update', $asset->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">NRG Serial Number</label>
            <input type="text" value="{{ $asset->nrg_serial_number }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-gray-100" readonly>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Asset Name</label>
            <input type="text" name="name" value="{{ old('name', $asset->name) }}" 
                class="mt-1 block w-full border border-gray-300 rounded-md p-2" {{ $asset->status === 'Returned to vendor' ? 'disabled' : '' }} required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Brand</label>
            <input type="text" name="brand" value="{{ old('brand', $asset->brand) }}" class="mt-1 block w-full border rounded p-2" {{ $asset->status === 'Returned to vendor' ? 'disabled' : '' }} required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Specification</label>
            <textarea name="specification" rows="3" class="mt-1 block w-full border rounded p-2" {{ $asset->status === 'Returned to vendor' ? 'disabled' : '' }} required>{{ old('specification', $asset->specification) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category" class="mt-1 block w-full border rounded p-2" {{ $asset->status === 'Returned to vendor' ? 'disabled' : '' }} required>
                @foreach(['Laptop','Monitor','Mouse','Keyboard','Others'] as $category)
                    <option value="{{ $category }}" {{ old('category', $asset->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Handling Type</label>
            <select name="handling_type" class="mt-1 block w-full border rounded p-2" {{ $asset->status === 'Returned to vendor' ? 'disabled' : '' }} required>
                @foreach(['Returnable','Non-returnable','Consumable'] as $type)
                    <option value="{{ $type }}" {{ old('handling_type', $asset->handling_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Vendor</label>
            <select name="vendor_id" class="mt-1 block w-full border rounded p-2" {{ $asset->status === 'Returned to vendor' ? 'disabled' : '' }} required>
                @foreach($vendors as $vendor)
                    <option value="{{ $vendor->id }}" {{ old('vendor_id', $asset->vendor_id) == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Procurement Date</label>
            <input type="date" name="procurement_date" value="{{ old('procurement_date', $asset->procurement_date->format('Y-m-d')) }}" class="mt-1 block w-full border rounded p-2" {{ $asset->status === 'Returned to vendor' ? 'disabled' : '' }} required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Status</label>

            @php
                $isAssigned = $asset->status === 'Assigned';
                $isVendorReturned = $asset->status === 'Returned to vendor';
            @endphp

            <select name="status" class="mt-1 block w-full border rounded p-2" {{ $isAssigned || $isVendorReturned ? 'disabled' : '' }} required>
                @foreach(['Unassigned','Assigned','Returned to vendor'] as $status)
                    <option value="{{ $status }}" {{ old('status', $asset->status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>

            {{-- If the status select is disabled it will not be submitted, so include hidden input with current status --}}
            @if($isAssigned || $isVendorReturned)
                <input type="hidden" name="status" value="{{ $asset->status }}">
                <p class="text-xs text-gray-500 mt-1">
                    @if($isAssigned)
                        Status is locked while asset is assigned to a user.
                    @elseif($isVendorReturned)
                        Asset returned to vendor — editing disabled.
                    @endif
                </p>
            @endif
        </div>

        <button type="submit" class="mt-4 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700" {{ $asset->status === 'Returned to vendor' ? 'disabled' : '' }}>Update Asset</button>
    </form>
</div>
@endsection