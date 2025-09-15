<form action="{{ route('admin.vendors.store') }}" method="POST" class="w-100">
    @csrf
    @include('admin.vendors._form')

    <div class="d-grid mt-3">
        <button type="submit" class="btn btn-success">
            Save
        </button>
    </div>
</form>
