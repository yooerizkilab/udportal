@extends('layouts.admin')

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> 
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tools Maintenances</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary">Tools Maintenances</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- form add vehicle insurance -->
                        <div class="col-4">
                            <form action="{{ route('tools-maintenances.store') }}" method="POST" id="addMaintenancesForm">
                                @csrf
                                <div class="form-group">
                                    <label for="vehicle_code">Tools Code</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" placeholder="Enter Vehicle Code" required>
                                </div>
                                <div class="form-group">
                                    <label for="cost">Cost</label>
                                    <input type="number" class="form-control @error('cost') is-invalid @enderror" id="cost" name="cost" placeholder="Enter Cost">
                                </div>
                                <div class="form-group">
                                    <label for="maintenance_date">Maintenances Date</label>
                                    <input type="date" class="form-control @error('maintenance_date') is-invalid @enderror" id="maintenance_date" name="maintenance_date" placeholder="Enter Maintenances Date">
                                </div>
                                <div class="form-group">
                                    <label for="description">Maintenances Description</label>
                                    <textarea name="description" id="description" class="form-control" id="" cols="30" rows="4"></textarea>
                                </div>
                            </form>
                            <div class="float-right my-3">
                                <button type="button" class="btn btn-primary" onclick="confirmAddMaintenances()"><i class="fas fa-check"></i> Save Maintenances</button>
                            </div>
                        </div>
                        <!--- List Car Insurance --->
                        <div class="col-8">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Vehicle Code</th>
                                            <th>Maintenances Date</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th width="10%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($maintenances as $maintenance)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $maintenance->tools->code }}</td>
                                                <td>{{ $maintenance->maintenance_date }}</td>
                                                <td>{{ $maintenance->description }}</td>
                                                <td><span class="badge badge-{{ $maintenance->badgeClass }}">{{ $maintenance->status }}</span></td>
                                                <td class="text-center">
                                                    <div class="d-inline-flex">
                                                        <a href="" class="btn btn-sm btn-info mr-1 btn-circle">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        @if ($maintenance->status != 'Completed')
                                                        <form action="{{ route('tools-maintenances.completeMaintenance', $maintenance->id) }}" method="POST" id="completeMaintenancesForm">
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-success mr-1 btn-circle" onclick="confirmCompleteMaintenances()">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('tools-maintenances.cancelMaintenance', $maintenance->id) }}" method="POST" id="cencelMaintenancesForm">
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-danger mr-1 btn-circle" onclick="confirmCencelMaintenances()">
                                                                <i class="fas fa-xmark"></i>
                                                            </button>
                                                        </form>
                                                        {{-- <form action="{{ route('tools-maintenances.pendingMaintenance', $maintenance->id) }}" method="POST" id="pendingMaintenancesForm">
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-secondary mr-1 btn-circle" onclick="confirmPendingMaintenances()">
                                                                <i class="fas fa-clock-rotate-left"></i>
                                                            </button>
                                                        </form> --}}
                                                        <button type="button" class="btn btn-sm btn-warning mr-1 btn-circle"
                                                            data-toggle="modal"
                                                            data-id="{{ $maintenance->id }}"
                                                            data-date="{{ $maintenance->maintenance_date }}"
                                                            data-cost="{{ $maintenance->cost }}"
                                                            data-description="{{ $maintenance->description }}"
                                                            data-target="#updateMaintenancesModal">
                                                            <i class="fas fa-pencil fa-md white-50"></i>
                                                        </button>
                                                        @endif
                                                    </div>
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
            </div>
        </div>
    </div>

    <!-- Modal update maintenance  -->
    <div class="modal fade" id="updateMaintenancesModal" tabindex="-1" role="dialog" aria-labelledby="updateMaintenancesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateMaintenancesModalLabel">Update Maintenance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tools-maintenances.update', ':id') }}" method="POST" id="updateMaintenancesForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <input type="number" class="form-control @error('cost') is-invalid @enderror" id="costEdit" name="cost" placeholder="Enter Cost">
                        </div>
                        <div class="form-group">
                            <label for="maintenance_date">Maintenances Date</label>
                            <input type="date" class="form-control @error('maintenance_date') is-invalid @enderror" id="maintenance_dateEdit" name="maintenance_date" placeholder="Enter Maintenances Date">
                        </div>
                        <div class="form-group">
                            <label for="description">Maintenances Description</label>
                            <textarea name="description" id="descriptionEdit" class="form-control" id="" cols="30" rows="4"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdateMaintenances()"><i class="fas fa-check"></i> Save</button>
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
        });
    }

    $('#updateMaintenancesModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var date = button.data('date');
        var cost = button.data('cost');
        var description = button.data('description');

        var modal = $(this);
        modal.find('#maintenance_dateEdit').val(date);
        modal.find('#costEdit').val(cost);
        modal.find('#descriptionEdit').val(description);
        modal.find('#updateMaintenancesForm').attr('action', modal.find('#updateMaintenancesForm').attr('action').replace(':id', id));
    })

    function confirmUpdateMaintenances() {
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
                $('#updateMaintenancesForm').submit();
            }
        });
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
        });
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