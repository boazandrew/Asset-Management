@extends('layouts.app')
@section('title', 'Assign Asset')
@section('content')
<div class="max-w-lg mx-auto bg-white shadow rounded-lg p-6">
    <h1 class="text-xl font-semibold mb-4">Assign Asset</h1>
    <form action="{{ route('admin.assignments.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Select Asset</label>
            <select name="asset_id" class="w-full border rounded p-2" required>
                <option value="">Select Asset</option>
                @foreach($assets as $asset)
                    <option value="{{ $asset->id }}">S.No: {{ $asset->nrg_serial_number }}: {{ $asset->name }}</option>
                @endforeach
            </select>
            @error('asset_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Assign to User</label>
            <select name="user_id" class="w-full border rounded p-2" required>
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            @error('user_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Assigned Date</label>
            <input name="assigned_date" type="date" class="w-full border rounded p-2" value="{{ old('assigned_date', now()->format('Y-m-d')) }}" required>
            @error('assigned_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded hover:bg-purple-700">Assign</button>
    </form>
</div>
@endsection
