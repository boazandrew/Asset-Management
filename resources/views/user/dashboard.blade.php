@extends('layouts.app')

@section('title', 'Dashboard - Asset Management System')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h1 class="h4 fw-bold mb-1">My Assigned Assets</h1>
            <p class="text-muted small mb-0">View and acknowledge your assigned assets</p>
        </div>
    </div>

    <!-- Summary Cards -->
    @if($assignments->count() > 0)
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-1">{{ $assignments->count() }}</h5>
                    <p class="text-muted small mb-0">Total Assets</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-success mb-1">{{ $assignments->where('acknowledged', true)->count() }}</h5>
                    <p class="text-muted small mb-0">Acknowledged</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-danger mb-1">{{ $assignments->where('acknowledged', false)->count() }}</h5>
                    <p class="text-muted small mb-0">Pending</p>
                </div>
            </div>
        </div>
    </div>
<br>
    <!-- Assets DataTable -->
    <div class="card shadow-sm mb-4">
        @if($assignments->count() > 0)
        <div class="card-header fw-bold">My Assets</div>
        <div class="card-body">
            <table id="userAssetsTable" class="table table-bordered table-striped align-middle" style="width: 100%;">
                <thead class="table-light">
                    <tr>
                        <th style="width: 8%;">NRG Serial No</th>
                        <th style="width: 20%;">Asset Details</th>
                        <th style="width: 10%;">Category</th>
                        <th style="width: 12%;">Assigned Date</th>
                        <th style="width: 12%;">Status</th>
                        <th style="width: 20%;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $assignment)
                    <tr>
                        <!-- Serial Number -->
                        <td>{{ $assignment->asset->nrg_serial_number }}</td>

                        <!-- Asset Details -->
                        <td>
                            <div>
                                <div class="fw-semibold">{{ $assignment->asset->name }}</div>
                                <div class="text-muted small">{{ $assignment->asset->brand }}</div>
                                <div class="text-secondary small">SN/ST: {{ $assignment->asset->product_serial_number }}</div>
                            </div>
                        </td>

                        <!-- Category Badge -->
                        <td>
                            <span class="badge 
                                @switch($assignment->asset->category->name)
                                    @case('Laptop') bg-primary @break
                                    @case('Monitor') bg-success @break
                                    @case('Mouse') bg-warning text-dark @break
                                    @case('Keyboard') bg-info text-dark @break
                                    @default bg-secondary
                                @endswitch">
                                {{ $assignment->asset->category->name }}
                            </span>
                        </td>

                        <!-- Assigned Date -->
                        <td>
                            {{ $assignment->assigned_date->format('d M Y') }}
                        </td>

                        <!-- Status -->
                        <td>
                            @if($assignment->returned)
                                <span class="badge bg-secondary">Returned</span>
                            @elseif($assignment->acknowledged)
                                <span class="badge bg-success">✓ Acknowledged</span>
                            @else
                                <span class="badge bg-danger">⚠ Pending</span>
                            @endif
                        </td>

                        <!-- Action -->
                        <td class="text-center">
                            @if(!$assignment->acknowledged && !$assignment->returned)
                                <form action="{{ route('user.acknowledge.asset', $assignment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to acknowledge this asset?')"
                                        class="btn btn-sm btn-success">
                                        <i class="bi bi-check-circle me-1"></i>Acknowledge
                                    </button>
                                </form>
                            @elseif($assignment->returned)
                                <span class="text-muted small">
                                    <i class="bi bi-arrow-return-left me-1"></i>Returned
                                </span>
                            @else
                                <span class="text-success small">
                                    <i class="bi bi-check-circle-fill me-1"></i>Already acknowledged
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center p-5">
            <svg class="mb-3 text-muted" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 
                         002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            <h5 class="fw-semibold">No assets assigned</h5>
            <p class="text-muted small mb-0">You don't have any assets assigned to you yet.</p>
        </div>
        @endif
    </div>
    @endif
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable only if there are assets
    @if($assignments->count() > 0)
    $('#userAssetsTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        searching: true,
        ordering: true,
        order: [[0, 'asc']], // Sort by Serial No ascending
        columnDefs: [
            { orderable: false, targets: -1 } // Last column (Action) not orderable
        ],
        autoWidth: true,
        language: {
            search: "Search My Assets:",
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
    @endif

    // GSAP Animations
    // Animate page header card
    gsap.from(".card.shadow-sm.mb-4:first-of-type", {
        opacity: 0,
        y: 20,
        duration: 0.6,
        ease: "power1.out"
    });

    // Animate assets table or empty state
    @if($assignments->count() > 0)
    gsap.from(".card.shadow-sm.mb-4:nth-of-type(2)", {
        opacity: 0,
        y: 15,
        duration: 0.6,
        ease: "power1.out",
        delay: 0.2
    });
    @else
    gsap.from(".text-center.p-5", {
        opacity: 0,
        scale: 0.95,
        duration: 0.6,
        ease: "power1.out",
        delay: 0.2
    });
    @endif

    // Summary cards animation
    gsap.from(".row.g-3 .col-12", {
        opacity: 0,
        y: 20,
        duration: 0.5,
        ease: "power1.out",
        stagger: 0.2,
        delay: 0.4
    });
});
</script>
@endsection