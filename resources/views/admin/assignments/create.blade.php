<form action="{{ route('admin.assignments.store') }}" method="POST" class="row g-3">
    @csrf
    @include('admin.assignments._form')

    <!-- Submit Button -->
    <div class="col-12 d-grid">
        <button type="submit" class="btn btn-primary">
            Assign
        </button>
    </div>
</form>
