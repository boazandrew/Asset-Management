@props(['name', 'label', 'type' => 'text'])
<div class="mb-4">
    <label for="{{ $name }}" class="block text-gray-700">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name) }}" class="w-full border rounded p-2">
    @error($name) <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>
