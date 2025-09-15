@extends('layouts.app')
@section('title','Edit Asset')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h1 class="h5 fw-bold mb-4">Edit Asset</h1>
                    {{-- Include form partial --}}
                    @include('admin.assets._form', ['asset' => $asset, 'vendors' => $vendors])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
