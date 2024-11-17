@extends('layouts.admin')

@push('css')
   <!-- Custom styles for this page -->
   <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
                    
<!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Vehicles</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.
    </p>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Type List Vehicles</h6>
                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#addVehiclesTypeModal">
                            <i class="fas fa-list fa-md white-50"></i> Add Types
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td width="5%">No</td>
                                        <td>Name</td>
                                        <td class="text-center" width="20%">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($vehicleTypes as $vehiclesType)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $vehiclesType->type_name }}</td>
                                            <td class="text-center">
                                                <div class="d-inline-flex">
                                                    <button type="button" class="btn btn-warning btn-sm mr-2 btn-circle" data-toggle="modal" data-target="#editVehiclesTypeModal">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="" method="post" id="deleteVehiclesTypeForm" class="d-inline">
                                                        <button type="button" class="btn btn-danger btn-sm btn-circle">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No Data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Owners List Vehicles</h6>
                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#addOwnerVehiclesModal">
                            <i class="fas fa-list fa-md white-50"></i> Add Owners
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td width="5%">No</td>
                                        <td>Name Owner</td>
                                        <td class="text-center" width="20%">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Owner 1</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                                <button type="button" class="btn btn-warning btn-sm mr-2 btn-circle" data-toggle="modal" data-target="#editVehiclesOwnerModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="" method="post" id="deleteVehiclesOwnerForm" class="d-inline">
                                                    <button type="button" class="btn btn-danger btn-sm btn-circle">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- @forelse ($vehicleOwners as $vehicleOwner)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $vehicleOwner->owner_name }}</td>
                                            <td class="text-center">
                                                <div class="d-inline-flex">
                                                    <button type="button" class="btn btn-warning btn-sm mr-2 btn-circle" data-toggle="modal" data-target="#editVehiclesOwnerModal">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="" method="post" id="deleteVehiclesOwnerForm" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm btn-circle">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No Data</td>
                                        </tr>
                                    @endforelse --}}
                                </tbody>
                            </table>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
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

                            <!-- Dropdown Filter -->
                            <div class="dropdown ml-2 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-filter fa-md white-50"></i> Filter
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                            
                            <!-- Tombol Import Data -->
                            <button type="button" class="btn btn-warning btn-md ml-2 mb-2" data-toggle="modal" data-target="#importVehiclesModal">
                                <i class="fas fa-file-import fa-md white-50"></i> Import Vehicles
                            </button>
                            <!-- Tombol Add Users -->
                            <button type="button" class="btn btn-primary btn-md ml-2 mb-2" data-toggle="modal" data-target="#addVehiclesModal">
                                <i class="fas fa-truck-fast fa-md white-50"></i> Add Vehicles
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
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Tahun</th>
                                        <th>Plat Nomor</th>
                                        <th>Status</th>
                                        <th width="10%" class="text-center" >Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($vehicles as $vehicle)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $vehicle->vehicle_code }}</td>
                                            <td>{{ $vehicle->brand }}</td>
                                            <td>{{ $vehicle->model }}</td>
                                            <td>{{ $vehicle->year }}</td>
                                            <td>{{ $vehicle->license_plate }}</td>
                                            <td><span class="badge badge-{{ $vehicle->badgeClass }}">{{ $vehicle->status }}</span></td>
                                            <td>
                                                <div class="d-inline-flex">
                                                    <button type="button" class="btn btn-info btn-sm mr-1 btn-circle" 
                                                        
                                                        data-toggle="modal" data-target="#viewVehiclesModal">
                                                        <i class="fas fa-eye"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-primary btn-sm mr-1 btn-circle"
                                                        
                                                        data-toggle="modal" data-target="#assignVehiclesModal">
                                                        <i class="fas fa-rotate"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-secondary btn-sm mr-1 btn-circle"
                                                        
                                                        data-toggle="modal" data-target="#mutationVehiclesModal">
                                                        <i class="fas fa-exchange"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-warning btn-sm mr-1 btn-circle"
                                                        
                                                        data-toggle="modal" data-target="#editVehiclesModal">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="" method="post" id="deleteVehiclesForm" class="d-inline">
                                                        @csrf
                                                        <button type="button" onclick="confirmVehiclesDelete()" class="btn btn-danger btn-sm btn-circle">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No Data</td>
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

    <!-- Modal View Vehicles -->
    <div class="modal fade" id="viewVehiclesModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Modal View Vehicles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Vehicles -->
    <div class="modal fade" id="addVehiclesModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Modal Add Vehicles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="addVehiclesForm" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="vehicle_code">Vehicle Code</label>
                            <input type="text" name="vehicle_code" id="vehicle_code" class="form-control" value="{{ $defaultCode }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input type="text" name="brand" id="brand" class="form-control @error('brand') is-invalid @enderror" required>
                        </div>
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" name="model" id="model" class="form-control @error('model') is-invalid @enderror" required>
                        </div>
                        <div class="form-group">
                            <label for="year">Year</label>
                            <input type="date" name="year" id="year" class="form-control @error('year') is-invalid @enderror" required>
                        </div>
                        <div class="form-group">
                            <label for="license_plate">License Plate</label>
                            <input type="text" name="license_plate" id="license_plate @error('license_plate') is-invalid @enderror" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="vehicle_type">Vehicle Type</label>
                            <select name="vehicle_type" id="vehicle_type" class="form-control @error('vehicle_type') is-invalid @enderror" required>
                                <option value="" disabled selected>Select Vehicle Type</option>
                                @foreach ($vehicleTypes as $vehicleType)
                                    <option value="{{ $vehicleType->id }}">{{ $vehicleType->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAddVehicles()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Type Vehicles -->
    <div class="modal fade" id="addVehiclesTypeModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Modal Add Type Vehicles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="addVehiclesTypeForm" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="vehicle_type">Vehicle Type</label>
                            <input type="text" name="vehicle_type" id="vehicle_type" class="form-control @error('vehicle_type') is-invalid @enderror" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAddType()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Owner Vehicles -->
    <div class="modal fade" id="addOwnerVehiclesModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Modal Add Owner Vehicles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAddOwner()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Assign Vehicles -->
    <div class="modal fade" id="assignVehiclesModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel">Modal Assign Vehicles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAssignVehicles()"><i class="fas fa-check"></i> Save Asingn</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Mutation Vehicles -->
    <div class="modal fade" id="mutationVehiclesModal" tabindex="-1" aria-labelledby="mutationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mutationModalLabel">Modal Mutation Vehicles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="mutationVehiclesForm" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="from">From</label>
                            <input type="text" name="from" id="from" class="form-control">
                        </div>
                        <div class="text-center">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <div class="form-group">
                            <label for="to">To</label>
                            <input type="text" name="to" id="to" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmMutationVehicles()"><i class="fas fa-check"></i> Save Mutation</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Vehicles -->
    <div class="modal fade" id="editVehiclesModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modal Edit Vehicles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="editVehiclesForm" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Vhicle Code</label>
                            <input type="text" name="vehicle_code" id="vehicle_code" class="form-control" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input type="text" name="brand" id="brand" class="form-control @error('brand') is-invalid @enderror" required>
                        </div>
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" name="model" id="model" class="form-control @error('model') is-invalid @enderror" required>
                        </div>
                        <div class="form-group">
                            <label for="year">Year</label>
                            <input type="date" name="year" id="year" class="form-control @error('year') is-invalid @enderror" required>
                        </div>
                        <div class="form-group">
                            <label for="license_plate">License Plate</label>
                            <input type="text" name="license_plate" id="license_plate @error('license_plate') is-invalid @enderror" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="vehicle_type">Vehicle Type</label>
                            <select name="vehicle_type" id="vehicle_type" class="form-control">
                                @foreach ($vehicleTypes as $vehicleType)
                                    <option value="{{ $vehicleType->id }}">{{ $vehicleType->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdateVehicles()"><i class="fas fa-check"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Type Vehicles -->
    <div class="modal fade" id="editVehiclesTypeModal" tabindex="-1" aria-labelledby="editTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTypeModalLabel">Modal Edit Type Vehicles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="editVehiclesTypeForm" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="vehicle_type">Vehicle Type</label>
                            <input type="text" name="vehicle_type" id="vehicle_type" class="form-control @error('vehicle_type') is-invalid @enderror" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdateType()"><i class="fas fa-check"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Owner Vehicles -->
    <div class="modal fade" id="editVehiclesOwnerModal" tabindex="-1" aria-labelledby="editOwnerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOwnerModalLabel">Modal Edit Owner Vehicles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="editOwnerVehiclesForm" method="post">
                        @csrf
                        @method('PUT')
                        ..
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdateOwner()"><i class="fas fa-check"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import Vehicles -->
    <div class="modal fade" id="importVehiclesModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Modal Import Vehicles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="importVehiclesForm" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" required>
                            <p class="text-danger">*Format file .xlsx .xls .csv</p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmImport()"><i class="fas fa-check"></i> Save</button>
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

    $(document).ready(function() {
        $('#dataTable1').DataTable();
    });

    $(document).ready(function() {
        $('#dataTable2').DataTable();
    });
</script>
@endpush