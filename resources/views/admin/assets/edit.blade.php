@extends('layouts.app')
@section('title','Edit Asset')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-xl font-semibold mb-4">Edit Asset</h1>
    @include('admin.assets._form', ['asset' => $asset, 'vendors' => $vendors])
</div>
@endsection