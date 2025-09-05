<form action="{{ route('admin.assignments.store') }}" method="POST">
    @include('admin.assignments._form')
    <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded hover:bg-purple-700">Assign</button>
</form>
