@extends ('layouts.app')

@section('title', 'Dashboard - Asset Management System')

@section('content')
<div id="dashboardMain" class="d-flex flex-column gap-4">
    <!-- Page Header -->
    <div class="bg-white shadow-sm rounded p-4">
        <h1 class="h4 fw-semibold mb-2">Admin Dashboard</h1>
        <p class="text-muted small mb-0">Manage your Assets, Users, Vendors</p>
    </div>

    <!-- Statistics -->
    <div class="row g-4">
        <!-- Total Assets -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="bg-white shadow-sm rounded p-4 d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="d-flex align-items-center justify-content-center bg-primary rounded-circle" style="width:40px; height:40px;">
                        <svg class="text-white" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="ms-3">
                    <div class="text-muted small">Total Assets</div>
                    <div class="fw-semibold">{{ $stats['total_assets'] }}</div>
                </div>
            </div>
        </div>
        <!-- Assigned Assets -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="bg-white shadow-sm rounded p-4 d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="d-flex align-items-center justify-content-center bg-warning rounded-circle" style="width:40px; height:40px;">
                        <svg class="text-white" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="ms-3">
                    <div class="text-muted small">Assigned</div>
                    <div class="fw-semibold">{{ $stats['assigned_assets'] }}</div>
                </div>
            </div>
        </div>
        <!-- Unassigned Assets -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="bg-white shadow-sm rounded p-4 d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="d-flex align-items-center justify-content-center bg-danger rounded-circle" style="width:40px; height:40px;">
                        <svg class="text-white" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="ms-3">
                    <div class="text-muted small">Unassigned</div>
                    <div class="fw-semibold">{{ $stats['unassigned_assets'] }}</div>
                </div>
            </div>
        </div>
        <!-- Returned Assets -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="bg-white shadow-sm rounded p-4 d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="d-flex align-items-center justify-content-center bg-success rounded-circle" style="width:40px; height:40px;">
                        <svg class="text-white" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                        </svg>
                    </div>
                </div>
                <div class="ms-3">
                    <div class="text-muted small">Returned</div>
                    <div class="fw-semibold">{{ $stats['returned_assets'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-2 g-md-3">
        <div class="col-12 col-md-4">
            <a href="{{ route('admin.assets.create') }}"
                onclick="event.preventDefault(); openUniversalModal('asset');"
                class="btn btn-primary w-100">Add Asset</a>
        </div>
        <div class="col-12 col-md-4">
            <a href="{{ route('admin.vendors.create') }}"
                onclick="event.preventDefault(); openUniversalModal('vendor');"
                class="btn btn-success w-100">Add Vendor</a>
        </div>
        <div class="col-12 col-md-4">
            <a href="{{ route('admin.assignments.create') }}"
                onclick="event.preventDefault(); openUniversalModal('assignment');"
                class="btn text-white w-100" style="background-color:#6f42c1;">Assign Asset</a>
        </div>
    </div>


    <!-- Assets Status -->
    <div class="bg-white shadow-sm rounded p-4">
        <h2 class="h6 fw-semibold mb-3">Assets Status</h2>
        <!-- Desktop Mode -->
        <div class="d-none d-md-block table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-0">
                    <tr class="text-muted small text-uppercase">
                        <th>Asset</th>
                        <th>User</th>
                        <th>Acknowledged</th>
                        <th>Returned</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach($assignments as $assignment)
                    <tr class="border-bottom">
                        <td class="fw-semibold">{{ $assignment->asset->name ?? '-' }}</td>
                        <td>{{ $assignment->user->name ?? '-' }}</td>
                        <td>
                            @if($assignment->acknowledged)
                            <span class="badge bg-success-subtle text-success">Acknowledged</span>
                            @else
                            <span class="badge bg-danger-subtle text-danger">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($assignment->returned && $assignment->returned_at)
                            <span class="badge bg-secondary-subtle text-muted">
                                Returned ({{ $assignment->returned_at->format('d M Y') }})
                            </span>
                            @else
                            <span class="badge bg-primary-subtle text-primary">Not Returned</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if(!$assignment->returned)
                            @if($assignment->asset && $assignment->asset->handling_type === 'Returnable')
                            <form action="{{ route('admin.assets.return', $assignment->asset->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-warning text-white shadow-sm"
                                    onclick="return confirm('Return this asset from user?')">
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
        <!-- Mobile View -->
        <div class="d-block d-md-none">
            @foreach($assignments as $assignment)
            <div class="card mb-3 border">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-1">Asset: <span class="mb-1 small text-muted">{{$assignment->asset->name?? '-'}}</span></h6>
                    <p class="mb-1 small text-muted fw-bold">User: {{$assignment->user->name ?? '-'}}</p>
                    <p class="mb-1"><span class="mb-1 small fw-semibold">Acknowledged: </span>
                        @if($assignment->acknowledged)
                        <span class="badge bg-success-subtle text-success">Acknowledged</span>
                        @else
                        <span class="badge bg-danger-subtle text-danger">Pending</span>
                        @endif
                    </p>
                    <p class="mb-1"><span class="mb-1 small fw-semibold">Returned: </span>
                        @if($assignment->returned && $assignment->returned_at)
                        <span class="badge bg-secondary-subtle text-muted">
                            Returned ({{ $assignment->returned_at->format('d M Y') }})
                        </span>
                        @else
                        <span class="badge bg-primary-subtle text-primary">Not Returned</span>
                        @endif
                    </p>
                    <p class="mb-1 small fw-semibold">
                        @if(!$assignment->returned)
                        @if($assignment->asset && $assignment->asset->handling_type === 'Returnable')
                    <form action="{{ route('admin.assets.return', $assignment->asset->id) }}"
                        method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-warning text-white shadow-sm"
                            onclick="return confirm('Return this asset from user?')">
                            Return
                        </button>
                    </form>
                    @else
                    <span class="text-muted small">No Return</span>
                    @endif
                    @else
                    <span class="text-muted small">Returned</span>
                    @endif
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Assets Table -->
    <div class="bg-white shadow-sm rounded p-4">
        <h2 class="h6 fw-semibold mb-3">Assets</h2>
        <!-- Desktop mode -->
        <div class="d-none d-md-block table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-0">
                    <tr class="text-muted small text-uppercase">
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Brand</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach(\App\Models\Asset::orderBy('id','asc')->get() as $asset)
                    <tr class="border-bottom">
                        <td class="fw-semibold">{{ $asset->nrg_serial_number }}</td>
                        <td class="fw-semibold">{{ $asset->name }}</td>
                        <td>
                            <!-- {{ $asset->status }} -->
                            @if($asset->status === 'Unassigned')
                            <span class="badge bg-success">Available</span>
                            @elseif($asset->status === 'Assigned')
                            <span class="badge bg-primary">Assigned</span>
                            @elseif($asset->status === 'Returned to vendor')
                            <span class="badge bg-secondary">Returned to vendor</span>
                            @endif
                        </td>
                        <td>{{ $asset->brand }}</td>
                        <td class="text-end">
                            @if($asset->status !== 'Returned to vendor')
                            <a href="{{ route('admin.assets.edit', $asset->id) }}"
                                onclick="event.preventDefault(); openUniversalModal('asset', {{ $asset->id }});"
                                class="btn btn-sm btn-primary">Edit</a>
                            @else
                            <button class="btn btn-sm btn-secondary" disabled>Edit</button>
                            @endif
                            <form action="{{ route('admin.assets.delete', $asset->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this asset?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Mobile view -->
        <div class="d-block d-md-none">
            @foreach(\App\Models\Asset::orderBy('id','asc')->get() as $asset)
            <div class="card mb-3 border">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-1">{{$asset->nrg_serial_number}} : {{$asset->name}}</h6>
                    <p class="mb-1"><span class="fw-semibold">{{$asset->status}}: </span>
                        @if($asset->status === 'Unassigned')
                        <span class="badge bg-success">Available</span>
                        @elseif($asset->status === 'Assigned')
                        <span class="badge bg-primary">Assigned</span>
                        @elseif($asset->status === 'Returned to vendor')
                        <span class="badge bg-secondary">Returned to vendor</span>
                        @endif
                    </p>
                    <p class="mb-1"><span class="fw-semibold">Brand: </span><span class="text-muted small">{{$asset->brand}}</span></p>
                    <div class="d-inline-flex gap-2 align-items-center mb-1">
                        @if($asset->status !== 'Returned to vendor')
                        <a href="{{ route('admin.assets.edit', $asset->id) }}"
                            onclick="event.preventDefault(); openUniversalModal('asset', {{ $asset->id }});"
                            class="btn btn-sm btn-primary">Edit</a>
                        @else
                        <button class="btn btn-sm btn-secondary" disabled>Edit</button>
                        @endif
                    <form action="{{ route('admin.assets.delete', $asset->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this asset?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Vendors Table -->
    <div class="bg-white shadow-sm rounded p-4">
        <h2 class="h6 fw-semibold mb-3">Vendors</h2>
        <!-- Desktop -->
        <div class="d-none d-md-block table-responsive">
            <table class="table table-hover align-middle mb-0 w-100">
                <colgroup>
                    <col style="width:35%;">
                    <col style="width:45%;">
                    <col style="width:20%;">
                </colgroup>
                <thead class="bg-light border-0">
                    <tr class="text-muted small text-uppercase">
                        <th>Name</th>
                        <th>Company</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach(App\Models\Vendor::all() as $vendor)
                    <tr class="border-bottom">
                        <td class="fw-semibold">{{ $vendor->name }}</td>
                        <td>{{ $vendor->company_name }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.vendors.edit', $vendor->id) }}"
                                onclick="event.preventDefault(); openUniversalModal('vendor', {{ $vendor->id }});"
                                class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.vendors.delete', $vendor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this vendor?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Mobile -->
        <div class="d-block d-md-none">
            @foreach(App\Models\Vendor::all() as $vendor)
            <div class="card mb-3 border">
                <div class="card-body p-3">
                    <p class="fw-bold mb-1">{{ $vendor->name }}</p>
                    <p class="fw-semibold mb-1">{{$vendor->company_name}}</p>
                    <div class="d-inline-flex gap-2 align-items-center mb-1 small fw-semibold">
                        <a href="{{ route('admin.vendors.edit', $vendor->id) }}"
                            onclick="event.preventDefault(); openUniversalModal('vendor', {{ $vendor->id }});"
                            class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('admin.vendors.delete', $vendor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this vendor?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- System Overview -->
    <div class="bg-white shadow-sm rounded p-4">
        <h2 class="h6 fw-bold mb-3 text-center text-md-start">System Overview</h2>
        <div class="row g-4 text-center text-md-start">
            <div class="col-12 col-md-6">
                <h6 class="text-muted small mb-1 fw-semibold">Users</h6>
                <p class="h5 fw-bold mb-1">{{ $stats['total_users'] }}</p>
                <p class="text-muted small fw-semibold">Total registered users</p>
            </div>
            <div class="col-12 col-md-6">
                <h6 class="text-muted small mb-1 fw-semibold">Vendors</h6>
                <p class="h5 fw-bold mb-1">{{ $stats['total_vendors'] }}</p>
                <p class="text-muted small fw-semibold">Active vendors</p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Universal Modal -->
<div class="modal fade" id="universalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg rounded">
            <div class="modal-header">
                <h5 id="universalModalTitle" class="modal-title fw-semibold">Modal</h5>
                <button type="button" class="btn-close" onclick="closeUniversalModal()"></button>
            </div>
            <div id="universalModalContent" class="modal-body">
                <div class="text-center small text-muted">Loading…</div>
            </div>
        </div>
    </div>
</div>

<script>
    function openUniversalModal(type, id = null) {
        const modalTitle = document.getElementById('universalModalTitle');
        const modalContent = document.getElementById('universalModalContent');
        let url = '';

        if (type === 'asset') {
            url = id ? `/admin/assets/${id}/edit` : `/admin/assets/create`;
            modalTitle.textContent = id ? 'Edit Asset' : 'Add Asset';
        } else if (type === 'vendor') {
            url = id ? `/admin/vendors/${id}/edit` : `/admin/vendors/create`;
            modalTitle.textContent = id ? 'Edit Vendor' : 'Add Vendor';
        } else if (type === 'assignment') {
            url = id ? `/admin/assignments/${id}/edit` : `/admin/assignments/create`;
            modalTitle.textContent = id ? 'Edit Assignment' : 'Assign Asset';
        }

        modalContent.innerHTML = '<div class="text-center py-4">Loading…</div>';

        fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(res => res.text())
            .then(html => modalContent.innerHTML = html)
            .catch(() => modalContent.innerHTML = '<div class="text-danger">Failed to load form.</div>');

        const modal = new bootstrap.Modal(document.getElementById('universalModal'));
        modal.show();
    }

    function closeUniversalModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('universalModal'));
        if (modal) modal.hide();
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Fade in header (very subtle)
        gsap.from(".navbar", {
            opacity: 0,
            duration: 0.6,
            ease: "power1.out"
        });

        // System overview and other cards
        gsap.from(".bg-white.shadow-sm.rounded.p-4", {
            opacity: 0,
            y: 15, // very small slide
            duration: 0.6,
            ease: "power1.out",
            stagger: 0.2,
            delay: 0.2
        });

        // Stats inside cards
        gsap.from(".row.g-4 .col-12", {
            opacity: 0,
            y: 10,
            duration: 0.5,
            ease: "power1.out",
            stagger: 0.15,
            delay: 0.4
        });

        // 🔥 Quick Actions buttons
        gsap.from(".row.g-2 .btn, .row.g-md-3 .btn", {
            opacity: 0,
            scale: 0.9,
            duration: 0.4,
            ease: "back.out(1.7)",
            stagger: 0.15,
            delay: 0.3
        });
    });
</script>

@endsection