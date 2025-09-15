@props(['name', 'label', 'type' => 'text'])
<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        value="{{ old($name) }}" 
        class="form-control @error($name) is-invalid @enderror"
        id="{{ $name }}"
    >
    @error($name) 
        <div class="invalid-feedback">{{ $message }}</div> 
    @enderror
</div>
