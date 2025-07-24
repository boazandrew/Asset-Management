@extends('layouts.app')
@section('title','Add Asset')
@section('content')
<div class="max-w-lg mx-auto bg-white shadow rounded-lg p-6">
    <h1 class="text-xl font-semibold mb-4">Add Asset</h1>
    <form action="{{ route('admin.assets.store') }}" method="POST">
        @csrf
        <x-input name="name" label="Asset Name" />
        <x-input name="brand" label="Brand" />
        <div class="mb-4">
            <label class="block text-gray-700">Specification</label>
            <textarea name="specification" class="w-full border rounded p-2" rows="3">{{ old('specification') }}</textarea>
            @error('specification') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <x-input name="nrg_serial_number" label="NRG Serial Number" />
        
        <div class="mb-4">
            <label class="block text-gray-700">Category</label>
            <select name="category" class="w-full border rounded p-2">
                <option value="">Select Category</option>
                @foreach(['Laptop','Monitor','Mouse','Keyboard','Others'] as $cat)
                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            @error('category') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Handle Type -->
        <div class="mb-4">
            <label class="block text-gray-700">Handling Type</label>
            <select name="handling_type" class="w-full border rounded p-2">
                <option value="">Select Handling Type</option>
                @foreach(['Returnable','Non-returnable','Consumable'] as $type)
                    <option value="{{ $type }}" {{ old('handling_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
            @error('handling_type') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Vendor selection -->
        <div class="mb-4">
            <label class="block text-gray-700">Vendor</label>
            <select name="vendor_id" class="w-full border rounded p-2">
                <option value="">Select Vendor</option>
                @foreach($vendors as $vendor)
                    <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                        {{ $vendor->name }}
                    </option>
                @endforeach
            </select>
            @error('vendor_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <x-input type="date" name="procurement_date" label="Procurement Date" />

        <!-- Status -->
        <div class="mb-4">
            <label class="block text-gray-700">Status</label>
            <select name="status" class="w-full border rounded p-2">
                @foreach(['Unassigned', 'Assigned', 'Returned to vendor'] as $status)
                    <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
            @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Save</button>
    </form>
</div>
@endsection
