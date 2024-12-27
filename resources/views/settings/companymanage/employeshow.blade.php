@extends('layouts.admin')

@push('css')

@endpush

@section('main-content')

<h1 class="h3 mb-2 text-gray-800">{{ __('Show Employee') }}</h1>
<p class="mb-4">
    this page is used to show employee
</p>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <h6 class="m-0 font-weight-bold text-primary">Employee Details</h6>
        <a href="{{ route('employees.index') }}" class="btn btn-primary btn-md mr-2"><i class="fas fa-reply"></i> Back</a>
    </div>
    <div class="card-body">
        
    </div>
</div>

@endsection

@push('scripts')

@endpush