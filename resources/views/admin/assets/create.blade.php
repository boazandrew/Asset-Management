@extends('layouts.app')
@section('title','Add Asset')
@section('content')
<div class="max-w-lg mx-auto bg-white shadow rounded-lg p-6">
    <h1 class="text-xl font-semibold mb-4">Add Asset</h1>
    @include('admin.assets._form', ['vendors' => $vendors])
</div>
@endsection