@extends('layouts.admin')

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> 
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Vehicles Assignment</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary">Vehicles Assignment</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- form add vehicle maintenances -->
                        <div class="col-4"> 
                            <form action="{{ route('vehicles-assign.store') }}" method="POST" id="addAssignmentForm">
                                @csrf
                                <div class="form-group">
                                    <label for="vehicle_code">Vehicle Code</label>
                                    <input type="text" class="form-control" id="vehicle_code" name="vehicle_code" placeholder="Enter Vehicle Code">
                                </div>
                                <div class="form-group">
                                    <label for="employee_name">Employee Name</label>
                                    <select name="employee_name" class="form-control" id="employee_name">
                                        <option value="" disabled selected>Select Employee Name</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->employe->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="return_date">Return Date</label>
                                    <input type="date" class="form-control" id="return_date" name="return_date" placeholder="Enter Maintenances Cost">
                                </div>
                                <div class="form-group">
                                    <label for="assignment_description">Assignment Description</label>
                                    <textarea name="assignment_description" id="assignment_description" class="form-control" id="" cols="30" rows="4"></textarea>
                                </div>
                            </form>
                            <div class="float-right mt-3">
                                <button type="button" class="btn btn-primary" onclick="confirmAddAssignment()"><i class="fas fa-check"></i> Save</button>
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
                                            <th>Name</th>
                                            <th>Assignment Date</th>
                                            <th>Return Date</th>
                                            <th>Status</th>
                                            <th>Assignment Description</th>
                                            <th width="10%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($assignments as $assignment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $assignment->vehicle->code }}</td>
                                                <td>{{ $assignment->employe->full_name }}</td>
                                                <td>{{ $assignment->assignment_date }}</td>
                                                <td>{{ $assignment->return_date }}</td>
                                                <td><span class="badge badge-{{ $assignment->badgeClass }}">{{ $assignment->badgeClass }}</span></td>
                                                <td>{{ $assignment->notes }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-primary" onclick="confirmUpdateAssignment({{ $assignment->id }})"><i class="fas fa-edit"></i></button>
                                                    <form action="{{ route('vehicles-assign.destroy', $assignment->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger" onclick="confirmDeleteAssignment({{ $assignment->id }})"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No Data</td>
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
@endpush