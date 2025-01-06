@extends('layouts.admin', [
    'title' => 'User Details'
])

@push('css')

@endpush

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">User Details</h1>
<p class="mb-4">
    This page is used to show user.
</p>

<!-- Card Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <h4 class="m-0 font-weight-bold text-primary">User Details</h4>
        <a href="{{ route('users.index') }}" class="btn btn-primary btn-md mr-2"><i class="fas fa-reply"></i> Back</a>
    </div>
    <div class="card-body">
        
    </div>
</div>

@endsection

@push('scripts')

@endpush