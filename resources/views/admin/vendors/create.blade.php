@extends('layouts.app')
@section('title','Add Vendor')
@section('content')
<div class="max-w-lg mx-auto bg-white shadow rounded-lg p-6">
    <h1 class="text-xl font-semibold mb-4">Add Vendor</h1>
    <form action="{{ route('admin.vendors.store') }}" method="POST">
        @csrf
        <x-input name="name" label="Vendor Name" />
        <x-input name="company_name" label="Company Name" />
        <div class="mb-4">
            <label class="block text-gray-700">Address</label>
            <textarea name="address" class="w-full border rounded p-2" rows="3">{{ old('address') }}</textarea>
            @error('address') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Save</button>
    </form>
</div>
@endsection
