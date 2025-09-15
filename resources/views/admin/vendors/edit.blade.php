<form action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST" class="w-100">
    @method('PUT')
    @csrf
    @include('admin.vendors._form')

    <div class="d-grid mt-3">
        <button type="submit" class="btn btn-primary">
            Update
        </button>
    </div>
</form>
