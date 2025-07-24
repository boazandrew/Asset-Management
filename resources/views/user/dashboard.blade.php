@extends('layouts.app')

@section('title', 'Dashboard - Asset Management System')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
     <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900">My Assigned Assets</h1>
        <p class="mt-1 text-sm text-gray-600">View and acknowledge your assigned assets</p>
    </div>

    <!-- Assets list -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        @if($assignments->count()>0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asset Details</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($assignments as $assignment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{$assignment->asset->name}}</div>
                                <div class="text-sm text-gray-500">{{$assignment->asset->brand}}</div>
                                <div class="text-xs text-gray-400">Serial: {{$assignment->asset->nrg_serial_number}}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full @switch($assignment->asset->category)
                                    @case('Laptop') bg-blue-100 text-blue-800 @break
                                    @case('Monitor') bg-green-100 text-green-800 @break
                                    @case('Mouse') bg-yellow-100 text-yellow-800 @break
                                    @case('Keyboard') bg-purple-100 text-purple-800 @break
                                    @default bg-gray-100 text-black @endswitch">
                                {{$assignment->asset->category}}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{$assignment->asset->vendor->name}}</div>
                            <div class="text-sm text-gray-500">{{$assignment->asset->vendor->company_name}}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{$assignment->assigned_date->format('d M Y')}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($assignment->returned)
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-200 text-gray-800">
                                    Returned
                                </span>
                            @elseif($assignment->acknowledged)
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    ✓ Acknowledged
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                    ⚠ Pending
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if(!$assignment->acknowledged && !$assignment->returned)
                                <form action="{{route('user.acknowledge.asset', $assignment->id)}}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Are you sure you want to acknowledge this asset?')" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Acknowledge</button>
                                </form>
                            @elseif($assignment->returned)
                                <span class="text-gray-400 text-xs">Returned</span>
                            @else
                                <span class="text-gray-400 text-xs">Already acknowledged</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <!-- Empty -->
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No assets assigned</h3>
            <p class="my-1 text-sm text-gray-500">You don't have any assets assigned to you yet.</p>
        </div>
        @endif
    </div>

    <!-- Summary -->
    @if($assignments->count() > 0)
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Summary</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-2xl font-semibold text-gray-900">{{ $assignments->count() }}</div>
                <div class="text-sm text-gray-500">Total Assets</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-semibold text-green-600">{{ $assignments->where('acknowledged', true)->count() }}</div>
                <div class="text-sm text-gray-500">Acknowledged</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-semibold text-red-600">{{ $assignments->where('acknowledged', false)->count() }}</div>
                <div class="text-sm text-gray-500">Pending</div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection