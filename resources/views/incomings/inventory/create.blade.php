@extends('layouts.admin', [
    'title' => 'Incoming Inventory Create'
])

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
<h1 class="h3 mb-4 text-gray-800">Incoming Inventory Create</h1>
<p class="mb-4">
    This page is used to create incoming inventory.
</p>

<!-- Create Incoming Inventory -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <h4 class="m-0 font-weight-bold text-primary">Create Incoming Inventory</h4>
        <a href="{{ route('incomings-inventory.index') }}" class="btn btn-primary btn-md mr-2">
            <i class="fas fa-reply"></i> 
            Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('incomings-inventory.store') }}" method="post" id="addIncomingInventoryForm">
            @csrf
            <div class="form-group">
                <label for="branch_id">Branch</label>
                <select name="branch_id" id="branch_id" class="form-control">
                    <option value="" disabled selected>Select Branch</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="supplier_id">Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="form-control">
                        <option value="" disabled selected>Select Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="warehouse_id">Warehouse</label>
                    <select name="warehouse_id" id="warehouse_id" class="form-control">
                        <option value="" disabled selected>Select Warehouse</option>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="eta">Date</label>
                    <input type="date" name="eta" id="eta" class="form-control" required>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="items-table">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Items</th>
                                        <th width="20%">Quantity</th>
                                        <th width="10%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>        
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-info mt-2" id="add-rows">
                            <i class="fas fa-plus-circle"></i> Add Items
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="text-right my-3 mr-3">
        <button type="button" class="btn btn-success" onclick="confirmAddIncomingInventory()">
            <i class="fas fa-truck-moving"></i> Create Incoming Inventory
        </button>
    </div>
</div>

@endsection

@push('scripts')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#items-table').DataTable({});
    });

    function confirmAddIncomingInventory() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want create this incoming inventory!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Create it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#addIncomingInventoryForm').submit();
            }
        })
    }

    $('#add-rows').on('click', function () {
        var table = $('#items-table').DataTable();
        var rowCount = table.rows().count();
        
        // Tambahkan baris baru dengan input dinamis
        table.row.add([
            rowCount + 1,
            '<input type="text" name="items[' + rowCount + '][item_name]" class="form-control">',
            '<input type="text" name="items[' + rowCount + '][quantity]" class="form-control">',
            '<div class="text-center">' +
                '<button type="button" class="btn btn-danger btn-circle delete-row">' +
                '<i class="fas fa-trash"></i>' +
                '</button>' +
            '</div>'
        ]).draw(false);
    });

    // Hapus baris dari tabel
    $('#items-table tbody').on('click', '.delete-row', function () {
        var table = $('#items-table').DataTable();

        // Hapus baris
        table.row($(this).closest('tr')).remove().draw();

        // Perbarui index semua baris
        table.rows().every(function (rowIdx, tableLoop, rowLoop) {
            this.cell(rowIdx, 0).data(rowIdx + 1).draw(false);
        });
    });
    
</script>
@endpush