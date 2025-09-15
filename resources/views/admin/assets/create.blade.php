@extends('layouts.app')
@section('title','Add Asset')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h1 class="h5 fw-bold mb-4">Add Asset</h1>
                    {{-- Include form partial --}}
                    @include('admin.assets._form', ['vendors' => $vendors])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
