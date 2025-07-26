@extends('layouts.app')

@section('title', 'Edit Vendor - Asset Management System')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Edit Vendor</h2>
    <form action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Vendor Name</label>
            <input type="text" name="name" value="{{ old('name', $vendor->name) }}" 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Company Name</label>
            <input type="text" name="company_name" value="{{ old('company_name', $vendor->company_name) }}" 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Address</label>
            <textarea name="address" rows="3"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>{{ old('address', $vendor->address) }}</textarea>
        </div>

        <button type="submit" class="mt-4 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Update Vendor</button>
    </form>
</div>
@endsection
