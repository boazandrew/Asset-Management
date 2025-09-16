<div class="card shadow-sm">
    <div class="card-header fw-bold">Asset Status</div>
    <div class="card-body">
        <table id="assetStatusTable" class="table table-bordered table-striped align-middle" style="width: 100%;">
            <thead class="table-light">
                <tr>
                    <th style="width: 8%;">S.no</th>
                    <th style="width: 12%;">Product S.no</th>
                    <th style="width: 15%;">Product Name</th>
                    <th style="width: 12%;">Assigned by</th>
                    <th style="width: 12%;">Assigned to</th>
                    <th style="width: 10%;">Assigned Date</th>
                    <th style="width: 12%;">Acknowledged</th>
                    <th style="width: 14%;">Returned</th>
                    <th style="width: 5%;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignments as $assignment)
                <tr>
                    <td>{{$assignment->asset->nrg_serial_number}}</td>
                    <td>{{$assignment->asset->product_serial_number}}</td>
                    <td>{{$assignment->asset->name}}</td>
                    <td>{{ $assignment->assignedBy?->name ?? '-' }}</td>
                    <td>{{$assignment->user->name?? '-'}}</td>
                    <td>{{ $assignment->created_at ? $assignment->created_at->format('d M Y') : '-' }}</td>
                    <td>
                        @if($assignment->acknowledged)
                            <span class="badge bg-success">Acknowledged</span>
                        @else
                            <span class="badge bg-danger">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if($assignment->returned && $assignment->returned_at)
                            <span class="badge bg-secondary">
                                Returned ({{ $assignment->returned_at->format('d M Y') }})
                            </span>
                        @else
                            <span class="badge bg-primary">Not Returned</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(!$assignment->returned)
                            @if($assignment->asset && $assignment->asset->handling_type === 'Returnable')
                                <form action="{{ route('admin.assets.return', $assignment->asset->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Return this asset from user?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning text-white" title="Return">
                                        Return
                                    </button>
                                </form>
                            @else
                                <span class="text-muted small">No Return</span>
                            @endif
                        @else
                            <span class="text-muted small">Returned</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#assetStatusTable').DataTable({
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
            search: "Search Asset Status:",
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