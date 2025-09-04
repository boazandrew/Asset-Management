@extends('layouts.app')
@section('title','Add Asset')
@section('content')
<div class="max-w-lg mx-auto bg-white shadow rounded-lg p-6">
    <h1 class="text-xl font-semibold mb-4">Add Asset</h1>
    <form action="{{ route('admin.assets.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">NRG Serial Number</label>
            <input type="text" value="{{ \App\Models\Asset::max('nrg_serial_number') ? \App\Models\Asset::max('nrg_serial_number') + 1 : 1 }}" 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 bg-gray-100" readonly>
            <p class="text-xs text-gray-500 mt-1">Assigned automatically</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Asset Name</label>
            <input name="name" value="{{ old('name') }}" type="text" class="mt-1 block w-full border rounded p-2" required>
            @error('name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Brand</label>
            <input name="brand" value="{{ old('brand') }}" type="text" class="mt-1 block w-full border rounded p-2" required>
            @error('brand')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Specification</label>
            <textarea name="specification" rows="3" class="mt-1 block w-full border rounded p-2" required>{{ old('specification') }}</textarea>
            @error('specification')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category" class="mt-1 block w-full border rounded p-2" required>
                <option value="">Select Category</option>
                @foreach(['Laptop','Monitor','Mouse','Keyboard','Others'] as $cat)
                    <option value="{{ $cat }}" {{ old('category')==$cat?'selected':'' }}>{{ $cat }}</option>
                @endforeach
            </select>
            @error('category')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Handling Type</label>
            <select name="handling_type" class="mt-1 block w-full border rounded p-2" required>
                <option value="">Select Handling Type</option>
                @foreach(['Returnable','Non-returnable','Consumable'] as $type)
                    <option value="{{ $type }}" {{ old('handling_type')==$type?'selected':'' }}>{{ $type }}</option>
                @endforeach
            </select>
            @error('handling_type')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Vendor</label>
            <select name="vendor_id" class="mt-1 block w-full border rounded p-2" required>
                <option value="">Select Vendor</option>
                @foreach($vendors as $vendor)
                    <option value="{{ $vendor->id }}" {{ old('vendor_id')==$vendor->id?'selected':'' }}>{{ $vendor->name }}</option>
                @endforeach
            </select>
            @error('vendor_id')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Procurement Date</label>
            <input type="date" name="procurement_date" value="{{ old('procurement_date') }}" class="mt-1 block w-full border rounded p-2" required>
            @error('procurement_date')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <input type="hidden" name="status" value="Unassigned" />

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Save</button>
    </form>
</div>
@endsection
