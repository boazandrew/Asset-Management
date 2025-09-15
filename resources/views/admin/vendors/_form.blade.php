@csrf
<div class="mb-3">
    <label class="form-label">Vendor Name</label>
    <input 
        type="text" 
        name="name" 
        value="{{ old('name', $vendor->name ?? '') }}" 
        class="form-control" 
        required
    >
    @error('name') 
        <div class="text-danger small">{{ $message }}</div> 
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Company Name</label>
    <input 
        type="text" 
        name="company_name" 
        value="{{ old('company_name', $vendor->company_name ?? '') }}" 
        class="form-control" 
        required
    >
    @error('company_name') 
        <div class="text-danger small">{{ $message }}</div> 
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Address</label>
    <textarea 
        name="address" 
        rows="3" 
        class="form-control" 
        required
    >{{ old('address', $vendor->address ?? '') }}</textarea>
    @error('address') 
        <div class="text-danger small">{{ $message }}</div> 
    @enderror
</div>
