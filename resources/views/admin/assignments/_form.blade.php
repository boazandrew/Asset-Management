@csrf
<div class="mb-3">
    <label class="form-label text-dark">Select Asset</label>
    <select name="asset_id" class="form-select" required>
        <option value="">Select Asset</option>
        @foreach($assets as $asset)
        <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
            S.No: {{ $asset->nrg_serial_number }} - {{ $asset->name }}
        </option>
        @endforeach
    </select>
    @error('asset_id') 
        <div class="text-danger small">{{ $message }}</div> 
    @enderror
</div>

<div class="mb-3">
    <label class="form-label text-dark">Assign to User</label>
    <select name="user_id" class="form-select" required>
        <option value="">Select User</option>
        @foreach($users as $user)
        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
            {{ $user->name }} ({{ $user->email }})
        </option>
        @endforeach
    </select>
    @error('user_id') 
        <div class="text-danger small">{{ $message }}</div> 
    @enderror
</div>

<div class="mb-3">
    <label class="form-label text-dark">Assigned Date</label>
    <input type="date" 
           name="assigned_date" 
           value="{{ old('assigned_date', now()->format('Y-m-d')) }}" 
           class="form-control" 
           required>
    @error('assigned_date') 
        <div class="text-danger small">{{ $message }}</div> 
    @enderror
</div>
