@extends('layouts.admin', [
    'title' => 'Vehicles Show Reimbursement'
])

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> 
@endpush

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Vehicles Show Reimbursement</h1>
<p class="mb-4">
    This page is used to show vehicles reimbursements.
</p>

<!-- Card Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <h4 class="m-0 font-weight-bold text-primary">Vehicles Reimbursement Details</h4>
        @if(Auth::user()->hasRole('Superadmin'))
            <a href="{{ route('reimbursements.index') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-reply"></i> 
                Back
            </a>
        @else
        <a href="{{ route('reimbursements.create') }}" class="btn btn-primary btn-md mr-2">
            <i class="fas fa-reply"></i> 
            Back
        </a>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="mt-4 mb-3">
                    <img src="https://auto2000.co.id/berita-dan-tips/_next/image?url=https%3A%2F%2Fastradigitaldigiroomuat.blob.core.windows.net%2Fstorage-uat-001%2Fmobil-mpv-adalah.jpg&w=3840&q=75" 
                        class="img-fluid rounded shadow-sm border border-primary w-100">
                </div>
            </div>
            <div class="col-md-8">
                <div class="text-left mb-4">
                    <h3 class="font-weight-bold text-primary">Approved By: {{ $reimbursement->user->fullName ?? 'Un Approved' }}</h3>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <span class="font-weight-bold text-muted">Type</span>
                            {!! $reimbursement->typeName !!}
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <span class="font-weight-bold text-muted">Status</span>
                            {!! $reimbursement->statusName !!}
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <span class="font-weight-bold text-muted">Fuel</span>
                            <span>{{ $reimbursement->fuel ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <span class="font-weight-bold text-muted">Date</span>
                            <span>{{ date('d F Y', strtotime($reimbursement->date_recorded)) }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <span class="font-weight-bold text-muted">First Mileage</span>
                            <span>{{ $reimbursement->first_mileage ?? '-' }} Mileage</span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <span class="font-weight-bold text-muted">Last Mileage</span>
                            <span>{{ $reimbursement->last_mileage ?? '-' }} Mileage</span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <span class="font-weight-bold text-muted">Amount</span>
                            <span>{{ $reimbursement->amount ?? '-' }} Liter</span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                            <span class="font-weight-bold text-muted">Price</span>
                            <span class="font-weight-bold text-primary">Rp {{ number_format($reimbursement->price,2) }}</span>
                        </div>
                    </div>
                </div>
                <h5 class="text-warning" >Notes: {{ $reimbursement->notes ?? '-' }}</h5>
                <h5 class="text-danger mb-3">Reason: {{ $reimbursement->reason ?? '-' }}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="text-center mb-4">
                    <h3 class="font-weight-bold text-primary">Reimbursement Details</h3>
                </div>
                <div class="row">
                    <div class="col-md-6 text-center mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Mileage Attachment</h5>
                            </div>
                            <div class="card-body">
                                @if(!empty($reimbursement->attachment_mileage))
                                    <img 
                                        src="{{ asset('storage/vehicle/reimbursements/mileage/'.$reimbursement->attachment_mileage) }}" 
                                        alt="Mileage Attachment" 
                                        class="img-fluid rounded shadow"
                                        style="max-height: 300px; object-fit: cover;"
                                    >
                                @else
                                    <p class="text-muted">No attachment available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Receipt Attachment</h5>
                            </div>
                            <div class="card-body">
                                @if(!empty($reimbursement->attachment_receipt))
                                    <img 
                                        src="{{ asset('storage/vehicle/reimbursements/receipt/'.$reimbursement->attachment_receipt) }}" 
                                        alt="Receipt Attachment" 
                                        class="img-fluid rounded shadow"
                                        style="max-height: 300px; object-fit: cover;"
                                    >
                                @else
                                    <p class="text-muted">No attachment available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>

@endsection

@push('scripts')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Page level custom scripts  -->
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush