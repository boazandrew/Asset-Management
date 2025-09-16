<div class="card shadow-sm">
    <div class="card-header fw-bold">Assets</div>
    <div class="card-body">
        <table id="assetsTable" class="table table-bordered table-striped align-middle" style="width: 100%;">
            <thead class="table-light">
                <tr>
                    <th style="width: 8%;">S.no</th>
                    <th style="width: 12%;">Product S.no</th>
                    <th style="width: 15%;">Product Name</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 10%;">Brand</th>
                    <th style="width: 18%;">Specification</th>
                    <th style="width: 10%;">Category</th>
                    <th style="width: 12%;">Vendor name</th>
                    <th style="width: 5%;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Asset::orderBy('id','asc')->get() as $asset)
                <tr>
                    <td>{{ $asset->nrg_serial_number }}</td>
                    <td>{{ $asset->product_serial_number }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>
                        @if($asset->status === 'Unassigned')
                            <span class="badge bg-success">Unassigned</span>
                        @elseif($asset->status === 'Assigned')
                            <span class="badge bg-primary">Assigned</span>
                        @elseif($asset->status === 'Returned to vendor')
                            <span class="badge bg-secondary">Returned to vendor</span>
                        @endif
                    </td>
                    <td>{{ $asset->brand }}</td>
                    <td>{{ $asset->specification }}</td>
                    <td>{{ $asset->category->name ?? '-' }}</td>
                    <td>{{ $asset->vendor->name ?? '-' }}</td>
                    <td class="text-center">
                        @if($asset->status !== 'Returned to vendor')
                            <a href="{{ route('admin.assets.edit', $asset->id) }}"
                               onclick="event.preventDefault(); openUniversalModal('asset', {{ $asset->id }});"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        @else
                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        @endif
                        
                        <form action="{{ route('admin.assets.delete', $asset->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure to delete this asset?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
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
    $('#assetsTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        searching: true,
        ordering: true,
        order: [[0, 'asc']], // Sort by S.no ascending
        columnDefs: [
            { orderable: false, targets: -1 } // Last column (Action) not orderable
        ],
        autoWidth: true,
        language: {
            search: "Search Assets:",
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