@csrf
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Vendor Name</label>
    <input type="text" name="name" value="{{ old('name', $vendor->name ?? '') }}"
        class="w-full border rounded p-2" required>
    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Company Name</label>
    <input type="text" name="company_name" value="{{ old('company_name', $vendor->company_name ?? '') }}"
        class="w-full border rounded p-2" required>
    @error('company_name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Address</label>
    <textarea name="address" rows="3" class="w-full border rounded p-2" required>{{ old('address', $vendor->address ?? '') }}</textarea>
    @error('address') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>