@extends('layouts.admin')

@push('css')
   <!-- Custom styles for this page -->
   <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
                    
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tables</h1>
<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            <div class="d-flex align-items-center flex-wrap">
                <input type="date" id="startDate" name="start_date" class="form-control mr-2 mb-2 w-auto" required>
                <input type="date" id="endDate" name="end_date" class="form-control mx-2 mb-2 w-auto" required>   
                <!-- Tombol PDF dengan AJAX -->
                <button type="button" onclick="printPDF()" class="btn btn-info btn-md ml-2 mb-2">
                    <i class="fas fa-file-pdf fa-md white-50"></i> Print PDF
                </button>
                <!-- Tombol Excel dengan AJAX -->
                <button type="button" onclick="printExcel()" class="btn btn-success btn-md ml-2 mb-2">
                    <i class="fas fa-file-excel fa-md white-50"></i> Print Excel
                </button>
                
                <!-- Tombol Import Data -->
                <button type="button" class="btn btn-warning btn-md ml-2 mb-2" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-import fa-md white-50"></i> Import Vehicles
                </button>
                <!-- Tombol Add Users -->
                <button type="button" class="btn btn-primary btn-md ml-2 mb-2" data-toggle="modal" data-target="#addUsersModal">
                    <i class="fas fa-truck-fast fa-md white-50"></i> Add Vehicles
                </button>
            </div>
        </div> 
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td>2011/04/25</td>
                            <td>$320,800</td>
                        </tr>
                    </tbody>
                </table>
            </div>
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