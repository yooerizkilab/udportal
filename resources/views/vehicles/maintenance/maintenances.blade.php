@extends('layouts.admin')

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> 
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Vehicles Maintenances</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.
    </p>

    <!-- 2 column grid -->
    <div class="row">
        <div class="col-12">
            <!-- card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Vehicles Maintenances</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- form add vehicle maintenances -->
                        <div class="col-4"> 
                            <form action="{{ route('vehicles-maintenances.store') }}" method="POST" id="addMaintenancesForm">
                                @csrf
                                <div class="form-group">
                                    <label for="vehicle_code">Vehicle Code</label>
                                    <input type="text" class="form-control" id="vehicle_code" name="vehicle_code" placeholder="Enter Vehicle Code">
                                </div>
                                <div class="form-group">
                                    <label for="maintenances_date">Maintenances Date</label>
                                    <input type="date" class="form-control" id="maintenances_date" name="maintenances_date" placeholder="Enter Maintenances Date">
                                </div>
                                <div class="form-group">
                                    <label for="maintenances_description">Maintenances Description</label>
                                    <textarea name="maintenances_description" id="maintenances_description" class="form-control" id="" cols="30" rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="maintenances_cost">Maintenances Cost</label>
                                    <input type="text" class="form-control" id="maintenances_cost" name="maintenances_cost" placeholder="Enter Maintenances Cost">
                                </div>
                                <div class="form-group">
                                    <label for="next_maintenances">Next Maintenances</label>
                                    <input type="date" class="form-control" id="next_maintenances" name="next_maintenances" placeholder="Enter Next Maintenances">
                                </div>
                            </form>
                            <div class="float-right mt-3">
                                <button type="button" class="btn btn-primary" onclick="confirmAddMaintenances()"><i class="fas fa-check"></i> Save</button>
                            </div>
                        </div>
                        <!--- List Car Maintenances --->
                        <div class="col-8">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Vehicle Code</th>
                                            <th>Maintenances Date</th>
                                            <th>Maintenances Description</th>
                                            <th>Maintenances Cost</th>
                                            <th>Next Maintenances</th>
                                            <th>Status</th>
                                            <th width="10%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($maintenances as $maintenance)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $maintenance->vehicle->code }}</td>
                                                <td>{{ $maintenance->maintenance_date }}</td>
                                                <td>{{ $maintenance->description }}</td>
                                                <td>Rp {{ number_format(($maintenance->cost), 2) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($maintenance->next_maintenance)) }}</td>
                                                <td><span class="badge badge-{{ $maintenance->status == 'Completed' ? 'success' : 'danger' }}">{{ $maintenance->status }}</span></td>
                                                <td class="text-center">
                                                    <div class="d-inline-flex">
                                                        <a href="{{ route('vehicles-maintenances.exportPdf', $maintenance->id) }}" class="btn btn-sm btn-info mr-1 btn-circle">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        @if ($maintenance->status != 'Completed')
                                                        <form action="{{ route('vehicles-maintenances.completeMaintenance', $maintenance->id) }}" method="POST" id="completeMaintenancesForm">
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-success mr-1 btn-circle" onclick="confirmCompleteMaintenances()">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        {{-- <button type="button" class="btn btn-sm btn-danger mr-1 btn-circle" onclick="confirmCancelledMaintenances({{ $maintenance->id }})">
                                                            <i class="fas fa-times"></i>
                                                        </button> --}}
                                                        <button type="button" class="btn btn-sm btn-warning btn-circle"
                                                            data-toggle="modal"
                                                            data-id="{{ $maintenance->id }}"
                                                            data-code="{{ $maintenance->vehicle->code }}"
                                                            data-date="{{ $maintenance->maintenance_date }}"
                                                            data-description="{{ $maintenance->description }}"
                                                            data-cost="{{ $maintenance->cost }}"
                                                            data-next="{{ $maintenance->next_maintenance }}"
                                                            data-target="#updateMaintenancesModal">
                                                            <i class="fas fa-pencil"></i>
                                                        </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No data available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <!-- Modal Update Maintenances -->
    <div class="modal fade" id="updateMaintenancesModal" tabindex="-1" role="dialog" aria-labelledby="updateMaintenancesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateMaintenancesModalLabel">Update Maintenances</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('vehicles-maintenances.update', ':id') }}" method="POST" id="updateMaintenancesForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="vehicle_code">Vehicle Code</label>
                            <input type="text" class="form-control" id="vehiclecode" name="vehicle_code" placeholder="Enter Vehicle Code" readonly>
                        </div>
                        <div class="form-group">
                            <label for="maintenances_date">Maintenances Date</label>
                            <input type="date" class="form-control" id="maintenancesdate" name="maintenances_date" placeholder="Enter Maintenances Date">
                        </div>
                        <div class="form-group">
                            <label for="maintenances_description">Maintenances Description</label>
                            <textarea name="maintenances_description" id="maintenancesdescription" class="form-control" id="" cols="30" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="maintenances_cost">Maintenances Cost</label>
                            <input type="text" class="form-control" id="maintenancescost" name="maintenances_cost" placeholder="Enter Maintenances Cost">
                        </div>
                        <div class="form-group">
                            <label for="next_maintenances">Next Maintenances</label>
                            <input type="date" class="form-control" id="nextmaintenances" name="next_maintenances" placeholder="Enter Next Maintenances">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdateMaintenances()"><i class="fas fa-check"></i> Save changes</button>
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

<script>
    function confirmAddMaintenances() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#addMaintenancesForm').submit();
            }
        })
    }

    $('#updateMaintenancesModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var code = button.data('code');
        var date = button.data('date');
        var description = button.data('description');
        var cost = button.data('cost');
        var next = button.data('next');

        var modal = $(this);
        modal.find('.modal-body #vehiclecode').val(code);
        modal.find('.modal-body #maintenancesdate').val(date);
        modal.find('.modal-body #maintenancesdescription').val(description);
        modal.find('.modal-body #maintenancescost').val(cost);
        modal.find('.modal-body #nextmaintenances').val(next);

        //replace action form
        var action = $('#updateMaintenancesForm').attr('action');
        var newAction = action.replace(':id', id);
        $('#updateMaintenancesForm').attr('action', newAction);
    })

    function confirmUpdateMaintenances() {
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
                $('#updateMaintenancesForm').submit();
            }
        })
    }

    function confirmCompleteMaintenances() {
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
                document.getElementById('completeMaintenancesForm').submit();
            }
        })
    }

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            showConfirmButton: true,
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ $errors->first() }}',
            showConfirmButton: true,
        });
    @endif
</script>
@endpush