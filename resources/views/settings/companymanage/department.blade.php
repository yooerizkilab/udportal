@extends('layouts.admin')

@push('css')
   <!-- Custom styles for this page -->
   <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
                    
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Department Management</h1>
    <p class="mb-4">
        This page is used to manage department.
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                <div class="d-flex align-items-center flex-wrap">
                    <input type="date" id="startDate" name="start_date" class="form-control mr-2 mb-2 w-auto" required>
                    <span class="mx-2">to</span>
                    <input type="date" id="endDate" name="end_date" class="form-control mx-2 mb-2 w-auto" required>   
                    <!-- Tombol PDF dengan AJAX -->
                    {{-- <button type="button" onclick="printPDF()" class="btn btn-info btn-md ml-2 mb-2">
                        <i class="fas fa-file-pdf fa-md white-50"></i> Print PDF
                    </button> --}}
                    <!-- Tombol Excel dengan AJAX -->
                    <button type="button" onclick="printExcel()" class="btn btn-success btn-md ml-2 mb-2">
                        <i class="fas fa-file-excel fa-md white-50"></i> Print Excel
                    </button>
                    
                    <!-- Tombol Import Data -->
                    {{-- <button type="button" class="btn btn-warning btn-md ml-2 mb-2" data-toggle="modal" data-target="#importModal">
                        <i class="fas fa-file-import fa-md white-50"></i> Import Department
                    </button> --}}
                    <!-- Tombol Add Users -->
                    <button type="button" class="btn btn-primary btn-md ml-2 mb-2" data-toggle="modal" data-target="#addDepartmentsModal">
                        <i class="fas fa-building-user fa-md white-50"></i> Add Department
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
                                <th>Name</th>
                                <th>Description</th>
                                <th width="10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departments as $department)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $department->code }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $department->description }}</td>
                                    <td>
                                        <div class="d-inline-flex">
                                            <button type="button" class="btn btn-warning mr-2 btn-circle"
                                                data-toggle="modal"
                                                data-id="{{ $department->id }}"
                                                data-company_id="{{ $department->company_id }}"
                                                data-name="{{ $department->name }}"
                                                data-description="{{ $department->description }}"
                                                data-target="#editDepartmentsModal">
                                                <i class="fas fa-pencil"></i>
                                            </button>
                                            <form action="{{ route('departments.destroy', $department->id) }}" method="POST" id="deleteDepartmentsForm-{{ $department->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-circle" onclick="confirmDeleteDepartment({{ $department->id }})"><i class="fas fa-trash"></i></button>
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

    <!-- Add Departments Modal-->
    <div class="modal fade" id="addDepartmentsModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-primary">
                    <h5 class="modal-title" id="addModalLabel">Modal Add Departments</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('departments.store') }}" method="POST" id="addDepartmentsForm">
                        @csrf
                        <div class="form-group">
                            <label for="company_id">Company</label>
                            <select name="company_id" class="form-control" id="company_id">
                                <option value="" disabled selected>Select Company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Description (optional)"></textarea>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                        <button type="button" class="btn btn-primary" onclick="confirmAddDepartments()"><i class="fas fa-check"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Departments Modal-->
    <div class="modal fade" id="editDepartmentsModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-primary">
                    <h5 class="modal-title" id="editModalLabel">Modal Edit Departments</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('departments.update', ':id') }}" method="POST" id="editDepartmentsForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="company_id">Company</label>
                            <select name="company_id" class="form-control" id="company_id">
                                <option value="" disabled selected>Select Company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Description (optional)"></textarea>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                        <button type="button" class="btn btn-primary" onclick="confirmUpdateDepartments()"><i class="fas fa-check"></i> Save changes</button>
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
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

    function confirmAddDepartments() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, add it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#addDepartmentsForm').submit();
            }
        })
    }

    $('#editDepartmentsModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var company_id = button.data('company_id');
        var name = button.data('name');
        var description = button.data('description');

        var modal = $(this);
        modal.find('#id').val(id);
        modal.find('#company_id').val(company_id);
        modal.find('#name').val(name);
        modal.find('#description').val(description);

        // Ubah action form agar sesuai dengan id yang akan diupdate
        var formAction = '{{ route("departments.update", ":id") }}';
        formAction = formAction.replace(':id', id);
        $('#editDepartmentsForm').attr('action', formAction);
    });

    function confirmUpdateDepartments() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#editDepartmentsForm').submit();
            }
        })
    }

    function confirmDeleteDepartment(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#deleteDepartmentsForm-' + id).submit();
            }
        })
    }
</script>
@endpush