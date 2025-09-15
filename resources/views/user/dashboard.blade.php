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

    <!-- Assets list -->
    <div class="card shadow-sm mb-4">
        @if($assignments->count()>0)
        <!-- Desktop mode -->
        <div class="d-none d-md-block table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-muted text-uppercase small">
                        <th>Asset Details</th>
                        <th>Category</th>
                        <th>Vendor</th>
                        <th>Assigned Date</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $assignment)
                    <tr>
                        <!-- Asset Details -->
                        <td>
                            <div>
                                <div class="fw-semibold">{{ $assignment->asset->name }}</div>
                                <div class="text-muted small">{{ $assignment->asset->brand }}</div>
                                <div class="text-secondary small">Serial: {{ $assignment->asset->nrg_serial_number }}</div>
                            </div>
                        </td>

                        <!-- Category Badge -->
                        <td>
                            <span class="badge 
                                @switch($assignment->asset->category)
                                    @case('Laptop') bg-primary @break
                                    @case('Monitor') bg-success @break
                                    @case('Mouse') bg-warning text-dark @break
                                    @case('Keyboard') bg-info text-dark @break
                                    @default bg-secondary
                                @endswitch">
                                {{ $assignment->asset->category }}
                            </span>
                        </td>

                        <!-- Vendor -->
                        <td>
                            <div class="fw-semibold">{{ $assignment->asset->vendor->name }}</div>
                            <div class="text-muted small">{{ $assignment->asset->vendor->company_name }}</div>
                        </td>

                        <!-- Assigned Date -->
                        <td class="small">
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
                        <td class="text-end">
                            @if(!$assignment->acknowledged && !$assignment->returned)
                            <form action="{{ route('user.acknowledge.asset', $assignment->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to acknowledge this asset?')"
                                    class="btn btn-sm btn-success">
                                    Acknowledge
                                </button>
                            </form>
                            @elseif($assignment->returned)
                            <span class="text-muted small">Returned</span>
                            @else
                            <span class="text-muted small">Already acknowledged</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Mobile view -->
        <div class="d-block d-md-none">
            @foreach($assignments as $assignment)
            <div class="card mb-3 border">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-1">{{$assignment->asset->name}}</h6>
                    <p class="mb-1 small text-muted">{{$assignment->asset->brand}} | Serial: {{$assignment->asset->nrg_serial_number}}</p>

                    <p class="mb-1"><span class="fw-semibold">Category:</span>
                        <span class="badge
                            @switch($assignment->asset->category)
                            @case('Laptop') bg-primary @break
                            @case('Monitor') bg-success @break
                            @case('Mouse') bg-warning text-dark @break
                            @case('Keyboard') bg-info text-dark @break
                            @default bg-secondary
                            @endswitch
                        ">
                            {{$assignment->asset->category}}
                        </span>
                    </p>

                    <p class="mb-1"><span class="fw-semibold">Vendor: </span>{{$assignment->asset->vendor->name}} <br>
                        <span class="text-muted small">{{$assignment->asset->vendor->company_name}}</span>
                    </p>

                    <p class="mb-1"><span class="fw-semibold">Assigned: </span>{{$assignment->assigned_date->format('d M Y')}}</p>

                    <p class="mb-2"><span class="fw-semibold">Status: </span>
                        @if($assignment->returned)
                        <span class="badge bg-secondary">Returned</span>
                        @elseif($assignment->acknowledged)
                        <span class="badge bg-success">✓ Acknowledged</span>
                        @else
                        <span class="badge bg-danger">⚠ Pending</span>
                        @endif
                    </p>
                    <!-- Action -->
                    <div>
                        @if(!$assignment->acknowledged && !$assignment->returned)
                        <form action="{{ route('user.acknowledge.asset', $assignment->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" onclick="return confirm('Are you sure you want to acknowledge this asset?')" class="btn btn-sm btn-success">
                                Acknowledge
                            </button>
                        </form>
                        @elseif($assignment->returned)
                        <span class="text-muted small">Returned</span>
                        @else
                        <span class="text-muted small">Already acknowledged</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
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

    <!-- Summary -->
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
    @endif
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Animate page header card
        gsap.from(".card.shadow-sm.mb-4:first-of-type", {
            opacity: 0,
            y: 20,
            duration: 0.6,
            ease: "power1.out"
        });

        // Animate assets list (desktop & mobile view)
        gsap.from(".table, .card.mb-3.border", {
            opacity: 0,
            y: 15,
            duration: 0.6,
            ease: "power1.out",
            stagger: 0.15,
            delay: 0.2
        });

        // Empty state (if no assets)
        gsap.from(".text-center.p-5", {
            opacity: 0,
            scale: 0.95,
            duration: 0.6,
            ease: "power1.out",
            delay: 0.2
        });

        // Summary cards
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