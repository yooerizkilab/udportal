@extends('layouts.admin')

@push('css')
   <!-- Custom styles for this page -->
   <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
                    
<!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Company Management</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="m-0 font-weight-bold text-primary">List Companies</h6>
                <div class="d-flex align-items-center flex-wrap">
                    <input type="date" id="startDate" name="start_date" class="form-control mr-2 mb-2 w-auto" required>
                    <span class="mx-2">to</span>
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
                        <i class="fas fa-file-import fa-md white-50"></i> Import Branches
                    </button>
                    <!-- Tombol Add Users -->
                    <button type="button" class="btn btn-primary btn-md ml-2 mb-2" data-toggle="modal" data-target="#addUsersModal">
                        <i class="fas fa-warehouse fa-md white-50"></i> Add Branches
                    </button>
                </div>
            </div> 
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Code</th>
                                <th>Branch</th>
                                <th>Status</th>
                                <th width="10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($branches as $branch)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $branch->code }}</td>
                                    <td>{{ $branch->name }}</td>
                                    <td>{{ $branch->status }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-info mr-1 btn-circle" data-toggle="modal" data-target="#viewCompaniesModal">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning mr-1 btn-circle" data-toggle="modal" data-target="#editCompaniesModal">
                                                <i class="fas fa-pencil"></i>
                                            </button>
                                            <form action="" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No data available</td>
                                </tr>
                            @endforelse
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