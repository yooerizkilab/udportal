@extends('layouts.admin', [
    'title' => 'Branch Management'
])

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
                    
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Branch Management</h1>
    <p class="mb-4">
        This page is used to manage branch.
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="m-0 font-weight-bold text-primary">List Branch</h4>
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
                        <i class="fas fa-file-import fa-md white-50"></i> Import Branches
                    </button> --}}
                    <!-- Tombol Add Users -->
                    <button type="button" class="btn btn-primary btn-md ml-2 mb-2" data-toggle="modal" data-target="#addBranchesModal">
                        <i class="fas fa-shop fa-md white-50"></i> Add Branches
                    </button>
                </div>
            </div> 
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Code</th>
                                <th>Branch</th>
                                <th>Database</th>
                                <th>Type</th>
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
                                    <td>{{ $branch->database }}</td>
                                    <td>{{ $branch->type }}</td>
                                    <td>{!! $branch->activeBranch !!}</td>
                                    <td class="text-center d-flex">
                                        <a href="{{ route('branches.show', $branch->id) }}" class="btn btn-info mr-1 btn-circle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-warning mr-1 btn-circle"
                                            data-toggle="modal"
                                            data-id="{{ $branch->id }}"
                                            data-company_id="{{ $branch->company_id }}"
                                            data-type="{{ $branch->type }}"
                                            data-name="{{ $branch->name }}"
                                            data-phone="{{ $branch->phone }}"
                                            data-address="{{ $branch->address }}"
                                            data-status="{{ $branch->status }}"
                                            data-description="{{ $branch->description }}"
                                            data-photo="{{ $branch->photo }}"
                                            data-target="#editBranchesModal">
                                            <i class="fas fa-pencil"></i>
                                        </button>
                                        <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" id="deleteBranchesForm-{{ $branch->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-circle" onclick="confirmDeleteBranches({{ $branch->id }})"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Branches -->
    <div class="modal fade" id="addBranchesModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary d-flex justify-content-center position-relative">
                    <h4 class="modal-title text-white font-weight-bold mx-auto" id="addModalLabel">Create Branches</h4>
                    <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="right: 15px; top: 15px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('branches.store') }}" method="post" id="addBranchesForm">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select name="type" class="form-control" id="type">
                                        <option value="" disabled selected>Select Type</option>
                                        <option value="Head Office">Head Office</option>
                                        <option value="Branch Office">Branch Office</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input type="file" class="form-control" id="photo" name="photo" placeholder="Select Photo">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control" cols="30" rows="4" placeholder="Address (optional)"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="4" placeholder="Description (optional)"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAddBranches()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Branches -->
    <div class="modal fade" id="editBranchesModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary d-flex justify-content-center position-relative">
                    <h4 class="modal-title text-white font-weight-bold mx-auto" id="editModalLabel">Update Branches</h4>
                    <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="right: 15px; top: 15px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('branches.update', ':id') }}" method="post" id="editBranchesForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
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
                                    <label for="type">Type</label>
                                    <select name="type" class="form-control" id="type">
                                        <option value="" disabled selected>Select Type</option>
                                        <option value="Head Office">Head Office</option>
                                        <option value="Branch Office">Branch Office</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input type="file" class="form-control" id="photo" name="photo" placeholder="Select Photo">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control" cols="30" rows="4" placeholder="Address (optional)"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="4" placeholder="Description (optional)"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdateBranches()"><i class="fas fa-check"></i> Save changes</button>
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
    
    function confirmAddBranches() {
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
                $('#addBranchesForm').submit();
            }
        })
    }

    $('#editBranchesModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var branchesId = button.data('id');
        var branchesCompany = button.data('company_id');
        var branchesName = button.data('name');
        var branchesType = button.data('type');
        var branchesPhone = button.data('phone');
        var branchesAddress = button.data('address');
        var branchesStatus = button.data('status');
        var branchesDescription = button.data('description');

        var modal = $(this);
        modal.find('#id').val(branchesId);
        modal.find('#company_id').val(branchesCompany);
        modal.find('#name').val(branchesName);
        modal.find('#type').val(branchesType);
        modal.find('#phone').val(branchesPhone);
        modal.find('#address').val(branchesAddress);
        modal.find('#status').val(branchesStatus);
        modal.find('#description').val(branchesDescription);

        // Ubah action form agar sesuai dengan id yang akan diupdate
        var formAction = '{{ route("branches.update", ":id") }}';
        formAction = formAction.replace(':id', branchesId);
        $('#editBranchesForm').attr('action', formAction);
    });

    function confirmUpdateBranches() {
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
                $('#editBranchesForm').submit();
            }
        })
    }

    function confirmDeleteBranches(branchesId) {
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
                document.getElementById('deleteBranchesForm-' + branchesId).submit();
            }
        })
    }
</script>
@endpush