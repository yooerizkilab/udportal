@extends('layouts.admin', [
    'title' => 'Warehouse Management'
])

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
                    
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Warehouse Management</h1>
    <p class="mb-4">
        This page is used to manage warehouse.
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="m-0 font-weight-bold text-primary">List Warehouses</h4>
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
                    <button type="button" class="btn btn-primary btn-md ml-2 mb-2" data-toggle="modal" data-target="#addWarehousesModal">
                        <i class="fas fa-warehouse fa-md white-50"></i> Add Warehouse
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
                                <th>Warehouse</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th width="15%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($warehouses as $warehouse)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $warehouse->code }}</td>
                                    <td>{{ $warehouse->name }}</td>
                                    <td>{!! $warehouse->typeName !!}</td>
                                    <td>{!! $warehouse->statusName !!}</td>
                                    <td class="text-center d-flex">
                                        <a href="{{ route('warehouses.show', $warehouse->id) }}" class="btn btn-info mr-1 btn-circle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-warning mr-1 btn-circle"
                                            data-toggle="modal"
                                            data-id="{{ $warehouse->id }}"
                                            data-companies="{{ $warehouse->company_id }}"
                                            data-branch="{{ $warehouse->branch_id }}"
                                            data-name="{{ $warehouse->name }}"
                                            data-phone="{{ $warehouse->phone }}"
                                            data-address="{{ $warehouse->address }}"
                                            data-description="{{ $warehouse->description }}"
                                            data-type="{{ $warehouse->type }}"
                                            data-status="{{ $warehouse->status }}"
                                            data-target="#editWarehouseModal">
                                            <i class="fas fa-pencil"></i>
                                        </button>
                                        <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" id="deleteWarehouseForm-{{ $warehouse->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-circle" onclick="confirmDeleteWarehouse({{ $warehouse->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
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

    <!-- Add Warehouse Modal-->
    <div class="modal fade" id="addWarehousesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary d-flex justify-content-center align-items-center">
                    <h4 class="modal-title text-white font-weight-bold mx-auto" id="exampleModalLabel">Add Warehouse</h4>
                    <button class="close position-absolute" type="button" data-dismiss="modal" aria-label="Close" style="right: 15px; top: 15px;">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('warehouses.store') }}" method="post" id="addWarehouseForm">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAddWarehouse()"><i class="fas fa-check"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Warehouse Modal-->
    <div class="modal fade" id="editWarehouseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary d-flex justify-content-center align-items-center">
                    <h4 class="modal-title text-white font-weight-bold mx-auto" id="exampleModalLabel">Update Warehouse</h4>
                    <button class="close position-absolute" type="button" data-dismiss="modal" aria-label="Close" style="right: 15px; top: 15px;">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('warehouses.update', ':id') }}" method="post" id="editWarehouseForm">
                        @csrf
                        @method('PUT')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdateWarehouse()"><i class="fas fa-check"></i> Save changes</button>
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

    function confirmAddWarehouse() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to create this warehouse!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Create it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#addWarehouseForm').submit();
            }
        });
    }

    $('#editWarehouseModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var company_id = button.data('company_id');
        var name = button.data('name');
        var description = button.data('description');
        var phone = button.data('phone');
        var address = button.data('address');
        var type = button.data('type');
        var status = button.data('status');

        var modal = $(this);
        modal.find('#id').val(id).trigger('change');
        modal.find('#company_id').val(company_id).trigger('change');
        modal.find('#name').val(name);
        modal.find('#description').val(description);
        modal.find('#phone').val(phone);
        modal.find('#address').val(address);
        modal.find('#type').val(type).trigger('change');
        modal.find('#status').val(status).trigger('change');

        // Ubah action form agar sesuai dengan id yang akan diupdate
        var formAction = '{{ route("warehouses.update", ":id") }}';
        formAction = formAction.replace(':id', id);
        $('#editWarehouseForm').attr('action', formAction);
    });
    
    function confirmUpdateWarehouse() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to update this warehouse!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#editWarehouseForm').submit();
            }
        });
    }
    
    function confirmDeleteWarehouse(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this warehouse!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#deleteWarehouseForm-' + id).submit();
            }
        });
    }
</script>
@endpush