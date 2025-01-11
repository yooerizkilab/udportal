@extends('layouts.admin', [
    'title' => 'Create Bids Analysis'
]);

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
<h1 class="h3 mb-4 text-gray-800">Create Bids Analysis</h1>
<p class="mb-4">
    This page is used to create bids analysis.
</p>

<!-- List Bids Analysis -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Create Bids Analysis</h6>
    </div>
    <div class="card-body">
        <h4 class="font-weight-bold text-primary">Bids</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="for_company" class="form-label">For Company</label>
                    <input type="text" class="form-control" id="for_company" name="for_company" placeholder="For Company" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date">
                </div>
            </div>
        </div>
        
        <h4 class="my-3 font-weight-bold text-primary">Items</h4>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Description</th>
                            <th width="10%">Quantity</th>
                            <th width="10%">UOM</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="float-right">
            <button type="button" class="btn btn-primary">Add Item</button>
        </div>
    </div>
</div>

@endsection

@push('script')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush