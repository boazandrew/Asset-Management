<form action="{{ route('admin.vendors.store') }}" method="POST">
    @include('admin.vendors._form')
    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Save</button>
</form>
