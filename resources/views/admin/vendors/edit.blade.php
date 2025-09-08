<form action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST">
    @method('PUT')
    @include('admin.vendors._form')
    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Update</button>
</form>