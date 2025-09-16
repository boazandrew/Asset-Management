<div class="card shadow-sm">
    <div class="card-header fw-bold">Vendors</div>
    <div class="card-body">
        <table id="vendorsTable" class="table table-bordered table-striped align-middle" style="width: 100%;">
            <thead class="table-light">
                <tr>
                    <th style="width: 8%;">S.no</th>
                    <th style="width: 25%;">Name</th>
                    <th style="width: 30%;">Company</th>
                    <th style="width: 32%;">Address</th>
                    <th style="width: 5%;" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach(App\Models\Vendor::orderBy('id', 'asc')->get() as $index => $vendor)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $vendor->name }}</td>
                    <td>{{ $vendor->company_name }}</td>
                    <td>{{ $vendor->address }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.vendors.edit', $vendor->id) }}"
                           onclick="event.preventDefault(); openUniversalModal('vendor', {{ $vendor->id }});"
                           class="btn btn-sm btn-primary">
                           <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('admin.vendors.delete', $vendor->id) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Delete this vendor?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#vendorsTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        searching: true,
        ordering: true,
        order: [[0, 'asc']], // Sort by S.no ascending
        columnDefs: [
            { orderable: false, targets: -1 } // Last column (Actions) not orderable
        ],
        autoWidth: true,
        language: {
            search: "Search Vendors:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });
});
</script>