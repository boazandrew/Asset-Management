@csrf
<div class="mb-4">
    <label class="block text-gray-700">Select Asset</label>
    <select name="asset_id" class="w-full border rounded p-2" required>
        <option value="">Select Asset</option>
        @foreach($assets as $asset)
        <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
            S.No: {{ $asset->nrg_serial_number }} - {{ $asset->name }}
        </option>
        @endforeach
    </select>
    @error('asset_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700">Assign to User</label>
    <select name="user_id" class="w-full border rounded p-2" required>
        <option value="">Select User</option>
        @foreach($users as $user)
        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
            {{ $user->name }} ({{ $user->email }})
        </option>
        @endforeach
    </select>
    @error('user_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700">Assigned Date</label>
    <input type="date" name="assigned_date" value="{{ old('assigned_date', now()->format('Y-m-d')) }}" class="w-full border rounded p-2" required>
    @error('assigned_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>