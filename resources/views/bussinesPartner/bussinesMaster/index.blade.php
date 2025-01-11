@extends('layouts.admin', [
    'title' => 'Bussines Master Management'
])

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush


@section('main-content')
<h1 class="h3 mb-4 text-gray-800">Bussines Master Management</h1>
<p class="mb-4">
    This page is used to manage bussines master.
</p>

<!-- List Bussines Master -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Bussines Master</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bussinesPartners['value'] as $bussinesPartner)
                    <tr>
                        <td>{{ $bussinesPartner->['CardCode'] }}</td>
                        <td>{{ $bussinesPartner->['CardName'] }}</td>
                        <td>{{ $bussinesPartner->['Phone1'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush