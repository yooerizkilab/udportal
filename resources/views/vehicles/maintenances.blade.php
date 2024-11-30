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
                            <form action="" method="POST" id="addMaintenancesForm">
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
                                                <td>{{ $maintenance->cost }}</td>
                                                <td>{{ $maintenance->next_maintenance }}</td>
                                                <td class="text-center">
                                                    <div class="d-inline-flex">
                                                        <button type="button" class="btn btn-sm btn-success mr-1 btn-circle" onclick="confirmCompleteMaintenances({{ $maintenance->id }})">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger mr-1 btn-circle" onclick="confirmCancelledMaintenances({{ $maintenance->id }})">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-warning btn-circle" data-toggle="modal" data-target="#updateMaintenancesModal">
                                                            <i class="fas fa-pencil"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No data available</td>
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