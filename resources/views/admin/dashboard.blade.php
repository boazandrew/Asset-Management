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

    <!-- Quick Actions -->
    <div class="row g-2 g-md-3">
        <div class="col-12 col-md-4">
            <a href="{{ route('admin.vendors.create') }}"
                onclick="event.preventDefault(); openUniversalModal('vendor');"
                class="btn btn-success w-100">Add Vendor</a>
        </div>
        <div class="col-12 col-md-4">
            <a href="{{ route('admin.assets.create') }}"
                onclick="event.preventDefault(); openUniversalModal('asset');"
                class="btn btn-primary w-100">Add Asset</a>
        </div>
        <div class="col-12 col-md-4">
            <a href="{{ route('admin.assignments.create') }}"
                onclick="event.preventDefault(); openUniversalModal('assignment');"
                class="btn text-white w-100" style="background-color:#6f42c1;">Assign Asset</a>
        </div>
    </div>

    <!-- Tables -->
    <div class="bg-white shadow-sm rounded p-4">
        <!-- Table Navigations -->
        <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
            <li class="nav-item" role="Presentation">
                <button class="nav-link active" id="status-tab" data-bs-toggle="tab" data-bs-target="#status" type="button" role="tab" aria-controls="status" aria-selected="true">
                    Assets Status
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="assets-tab" data-bs-toggle="tab" data-bs-target="#assets" type="button" role="tab" aria-controls="assets" aria-selected="true">
                    Assets
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="vendors-tab" data-bs-toggle="tab" data-bs-target="#vendors" type="button" role="tab" aria-controls="vendors" aria-selected="true">
                    Vendors
                </button>
            </li>
        </ul>

        <div class="tab-content mt-3" class="dashboardTabsContent">
            <!-- Asset status -->
            <div class="tab-pane fade show active" id="status" role="tabpanel" aria-labelledby="status-tab">
                @include('admin.tables.assets_status')
            </div>

            <!-- Assets -->
            <div class="tab-pane fade" id="assets" role="tabpanel" aria-labelledby="assets-tab">
                @include('admin.tables.assets')
            </div>

            <!-- Vendors -->
            <div class="tab-pane fade" id="vendors" role="tabpanel" aria-labelledby="vendors-tab">
                @include('admin.tables.vendors')
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
    document.addEventListener("DOMContentLoaded", function() {
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