@extends ('layouts.app')

@section('title', 'Dashboard - Asset Management System')

@section('content')
<div id="dashboardMain" class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl shadow rounded-lg p-6">Admin Dashboard</h1>
        <p class="mt-1 text-sm text-gray-600">Manage your Assets, Users, Vendors</p>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Assets -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Assets</dt>
                            <dd class="text-lg font-medium text-gray-900 truncate">{{$stats['total_assets']}}</dd>

                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <!-- Assigned Assets -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Assigned</dt>
                            <dd class="text-lg font-medium text-gray-900">{{$stats['assigned_assets']}}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <!-- Unassigned Assets -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Unassigned</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['unassigned_assets'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <!-- Returned Assets -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Returned</dt>
                            <dd class="text-lg font-medium text-gray-900">{{$stats['returned_assets']}}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick Actions -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.assets.create') }}"
                onclick="event.preventDefault(); openUniversalModal('asset');"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700">
                Add Asset
            </a>
            <a href="{{ route('admin.vendors.create') }}"
                onclick="event.preventDefault(); openUniversalModal('vendor');"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700">
                Add Vendor
            </a>
            <a href="{{ route('admin.assignments.create') }}"
                onclick="event.preventDefault(); openUniversalModal('assignment');"
                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded shadow hover:bg-purple-700">
                Assign Asset
            </a>

            <!-- <a href="{{ route('admin.assignments.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v1a1 1 0 01-1 1v12a2 2 0 01-2 2H4a2 2 0 01-2-2V7a1 1 0 01-1-1V5a1 1 0 011-1h4zM9 3v1h6V3H9z"></path>
                </svg>
                Assign Asset
            </a> -->
        </div>
    </div>

    <!-- Returned & Acknowledgement Table -->
    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Assets Status</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asset</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acknowledged</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Returned</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($assignments as $assignment)
                    <tr>
                        <td class="px-6 py-4">{{ $assignment->asset->name ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $assignment->user->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($assignment->acknowledged)
                            <span class="text-green-600">Acknowledged</span>
                            @else
                            <span class="text-red-600">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($assignment->returned && $assignment->returned_at)
                            <span class="text-gray-600">Returned ({{ $assignment->returned_at->format('d M Y') }})</span>
                            @else
                            <span class="text-blue-600">Not Returned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if(!$assignment->returned)
                            @if($assignment->asset && $assignment->asset->handling_type === 'Returnable')
                            <form action="{{ route('admin.assets.return', $assignment->asset->id) }}" method="POST" style="display:inline-block">
                                @csrf
                                <button class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700" onclick="return confirm('Return this asset from user?')">Return</button>
                            </form>
                            @else
                            <span class="text-gray-400">No Return</span>
                            @endif
                            @else
                            <span class="text-gray-400">Returned</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Assets Table -->
    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Assets</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">S.No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach(\App\Models\Asset::orderBy('id','asc')->get() as $asset)
                <tr>
                    <td class="px-6 py-4">{{ $asset->nrg_serial_number }}</td>
                    <td class="px-6 py-4">{{ $asset->name }}</td>
                    <td class="px-6 py-4">{{ $asset->brand }}</td>
                    <td class="px-6 py-4">{{ $asset->status }}</td>
                    <td class="px-6 py-4 flex space-x-2">
                        @if($asset->status !== 'Returned to vendor')
                        <a href="{{ route('admin.assets.edit', $asset->id) }}"
                            onclick="event.preventDefault(); openUniversalModal('asset', {{ $asset->id }});"
                            class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Edit
                        </a>
                        @else
                        <button class="px-3 py-1 bg-gray-300 text-gray-700 rounded cursor-not-allowed" disabled>Edit</button>
                        @endif

                        <form action="{{ route('admin.assets.delete', $asset->id) }}" method="POST" onsubmit="return confirm('Delete this asset?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Vendors Table -->
    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Vendors</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach(App\Models\Vendor::all() as $vendor)
                <tr>
                    <td class="px-6 py-4">{{ $vendor->name }}</td>
                    <td class="px-6 py-4">{{ $vendor->company_name }}</td>
                    <td class="px-6 py-4 flex space-x-2">
                        <a href="{{ route('admin.vendors.edit', $vendor->id) }}"
                            onclick="event.preventDefault(); openUniversalModal('vendor', {{ $vendor->id }});"
                            class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Edit
                        </a>
                        <form action="{{ route('admin.vendors.delete', $vendor->id) }}" method="POST" onsubmit="return confirm('Delete this vendor?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Recent Activity -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">System Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Users</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
                <p class="text-sm text-gray-500">Total registered users</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Vendors</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_vendors'] }}</p>
                <p class="text-sm text-gray-500">Active vendors</p>
            </div>
        </div>
    </div>
</div>
<!-- Universal Modal (Assets / Vendors / Assignments) -->
<div id="universalModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <!-- overlay -->
    <div id="universalModalOverlay" class="absolute inset-0 bg-black bg-opacity-40"></div>

    <!-- modal box -->
    <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4 z-10">
        <div class="flex items-center justify-between px-4 py-3 border-b">
            <h3 id="universalModalTitle" class="text-lg font-semibold">Modal</h3>
            <button type="button" onclick="closeUniversalModal()" class="text-gray-600 hover:text-gray-900 text-xl px-2">&times;</button>
        </div>
        <div id="universalModalContent" class="p-4 max-h-[70vh] overflow-auto">
            <div class="text-center text-sm text-gray-500">Loading…</div>
        </div>
    </div>
</div>
<script>
    function setDashboardBlur(on) {
        const dash = document.getElementById('dashboardMain');
        if (!dash) return;
        if (on) {
            dash.classList.add('filter', 'blur-sm', 'pointer-events-none', 'select-none');
        } else {
            dash.classList.remove('filter', 'blur-sm', 'pointer-events-none', 'select-none');
        }
    }

    function openUniversalModal(type, id = null) {
        const modal = document.getElementById('universalModal');
        const modalTitle = document.getElementById('universalModalTitle');
        const modalContent = document.getElementById('universalModalContent');

        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex', 'items-start', 'justify-center', 'p-8');
        setDashboardBlur(true);

        // Define route URLs
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

        // Load content
        modalContent.innerHTML = '<div class="text-center py-8">Loading…</div>';
        fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(res => res.text())
            .then(html => modalContent.innerHTML = html)
            .catch(err => {
                modalContent.innerHTML = '<div class="text-red-500">Failed to load form.</div>';
                console.error(err);
            });
    }

    function closeUniversalModal() {
        const modal = document.getElementById('universalModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex', 'items-start', 'justify-center', 'p-8');
        document.getElementById('universalModalContent').innerHTML = '';
        setDashboardBlur(false);
    }

    // Close on overlay click
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('universalModal');
        if (!modal || modal.classList.contains('hidden')) return;
        const overlay = document.getElementById('universalModalOverlay');
        if (overlay && e.target === overlay) closeUniversalModal();
    });

    // Close on ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeUniversalModal();
    });
</script>
@endsection