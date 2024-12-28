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
        <div class="col-lg-12">
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
                            <!-- Dropdown Filter -->
                            {{-- <div class="dropdown ml-2 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-filter fa-md white-50"></i> Filter
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div> --}}
                            @can('create vehicle')
                            <!-- Tombol Import Data -->
                            <button type="button" class="btn btn-warning btn-md ml-2 mb-2" data-toggle="modal" data-target="#importVehiclesModal">
                                <i class="fas fa-file-import fa-md white-50"></i> Import Vehicles
                            </button>
                            <!-- Tombol Add Users -->
                            <button type="button" class="btn btn-primary btn-md ml-2 mb-2" data-toggle="modal" data-target="#addVehiclesModal">
                                <i class="fas fa-truck-fast fa-md white-50"></i> Add Vehicles
                            </button>
                            @endcan
                        </div>
                    </div> 
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Code</th>
                                        <th>Model</th>
                                        <th>License Plate</th>
                                        <th>Tax Year</th>
                                        <th>Tax Five Year</th>
                                        <th>Inspected</th>
                                        <th>Assigned</th>
                                        <th>Status</th>
                                        <th width="10%" class="text-center" >Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($vehicles as $vehicle)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $vehicle->code }}</td>
                                            <td>{{ $vehicle->model }}</td>
                                            <td>{{ $vehicle->license_plate }}</td>
                                            <td>{{ date('d M Y', strtotime($vehicle->tax_year)) }}</td>
                                            <td>{{ date('d M Y', strtotime($vehicle->tax_five_year)) }}</td>
                                            <td>{{ date('d M Y', strtotime($vehicle->inspected)) }}</td>
                                            <td>{{ $vehicle->assigned->full_name ?? '-' }}</td>
                                            <td><span class="badge badge-{{ $vehicle->badgeClass }}">{{ $vehicle->status }}</span></td>
                                            <td>
                                                <div class="d-inline-flex">
                                                    <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-info mr-1 btn-circle">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @can('assign vehicle')
                                                    <button type="button" class="btn btn-primary mr-1 btn-circle"  
                                                        data-toggle="modal"
                                                        data-id="{{ $vehicle->id }}"
                                                        data-target="#assignVehiclesModal">
                                                        <i class="fas fa-rotate"></i>
                                                    </button>
                                                    @endcan
                                                    {{-- <button type="button" class="btn btn-secondary mr-1 btn-circle"
                                                        data-toggle="modal" data-target="#transferVehiclesModal">
                                                        <i class="fas fa-exchange"></i>
                                                    </button> --}}
                                                    @can('update vehicle')
                                                    <button type="button" class="btn btn-warning mr-1 btn-circle"
                                                        data-toggle="modal"
                                                        data-id="{{ $vehicle->id }}"
                                                        data-owner="{{ $vehicle->ownership->name }}"
                                                        data-type="{{ $vehicle->type->name }}"
                                                        data-brand="{{ $vehicle->brand }}"
                                                        data-model="{{ $vehicle->model }}"
                                                        data-color="{{ $vehicle->color }}"
                                                        data-transmisi="{{ $vehicle->transmission }}"
                                                        data-fuel="{{ $vehicle->fuel }}"
                                                        data-year="{{ $vehicle->year }}"
                                                        data-license_plate="{{ $vehicle->license_plate }}"
                                                        data-tax_year="{{ $vehicle->tax_year }}"
                                                        data-tax_five_year="{{ $vehicle->tax_five_year }}"
                                                        data-inspected="{{ $vehicle->inspected }}"
                                                        data-purchase_date="{{ $vehicle->purchase_date }}"
                                                        data-purchase_price="{{ $vehicle->purchase_price }}"
                                                        data-description="{{ $vehicle->description }}"
                                                        data-origin="{{ $vehicle->origin }}"
                                                        data-photo="{{ $vehicle->photo }}"
                                                        data-target="#updateVehiclesModal">
                                                        <i class="fas fa-pencil"></i>
                                                    </button>
                                                    @endcan
                                                    @can('delete vehicle')
                                                    <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="post" id="deleteVehiclesForm" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="confirmVehiclesDelete()" class="btn btn-danger btn-circle">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No Data</td>
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
                        <h6 class="m-0 font-weight-bold text-primary">Type List Vehicles</h6>
                        @can('create vehicle categories')
                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#addVehiclesTypeModal">
                            <i class="fas fa-list fa-md white-50"></i>
                        </button>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td width="5%">No</td>
                                        <td>Name</td>
                                        <td>Description</td>
                                        <td class="text-center" width="20%">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($vehicleTypes as $vehiclesType)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $vehiclesType->name }}</td>
                                            <td>{{ $vehiclesType->description }}</td>
                                            <td class="text-center">
                                                <div class="d-inline-flex">
                                                    @can('update vehicle categories')
                                                    <button type="button" class="btn btn-warning mr-2 btn-circle"
                                                        data-toggle="modal"
                                                        data-id="{{ $vehiclesType->id }}"
                                                        data-name="{{ $vehiclesType->name }}"
                                                        data-description="{{ $vehiclesType->description }}"
                                                        data-target="#editVehiclesTypeModal">
                                                        <i class="fas fa-pencil"></i>
                                                    </button>
                                                    @endcan
                                                    @can('delete vehicle categories')
                                                    <form action="{{ route('types.destroy', $vehiclesType->id) }}" method="post" id="deleteVehiclesTypeForm" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-circle" onclick="confirmVehiclesTypeDelete()">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endcan
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
    </div>

    <!-- Modal Add Vehicles -->
    <div class="modal fade" id="addVehiclesModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Modal Add Vehicles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('vehicles.store') }}" id="addVehiclesForm" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <input type="text" name="brand" id="brand" class="form-control @error('brand') is-invalid @enderror" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <input type="text" name="model" id="model" class="form-control @error('model') is-invalid @enderror" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ownership">Ownership</label>
                                    <select name="ownership" id="ownership" class="form-control @error('ownership') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Ownership</option>
                                        @foreach ($vehicleOwnerships as $ownership)
                                            <option value="{{ $ownership->id }}">{{ $ownership->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="license_plate">License Plate</label>
                                    <input type="text" name="license_plate" id="license_plate @error('license_plate') is-invalid @enderror" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <input type="number" name="year" id="year" class="form-control @error('year') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror" required>
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vehicle_type">Vehicle Type</label>
                                    <select name="vehicle_type" id="vehicle_type" class="form-control @error('vehicle_type') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Vehicle Type</option>
                                        @foreach ($vehicleTypes as $vehicleType)
                                            <option value="{{ $vehicleType->id }}">{{ $vehicleType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="fuel">Fuel</label>
                                    <select name="fuel" id="fuel" class="form-control @error('fuel') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Fuel</option>
                                        <option value="Gasoline">Gasoline</option>
                                        <option value="Diesel">Diesel</option>
                                    </select>
                                </div>   
                                <div class="form-group">
                                    <label for="purchase_price">Purchase Price</label>
                                    <input type="text" name="purchase_price" id="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="purchase_date">Purchase Date</label>
                                    <input type="date" name="purchase_date" id="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror" required>
                                </div> 
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="transmission">Transmission</label>
                                    <select name="transmission" id="transmission" class="form-control @error('transmission') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Transmission</option>
                                        <option value="Automatic">Automatic</option>
                                        <option value="Manual">Manual</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tax_year">Tax Year</label>
                                    <input type="date" name="tax_year" id="tax_year" class="form-control @error('tax_year') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="tax_five_years">Tax Five Years</label>
                                    <input type="date" name="tax_five_year" id="tax_five_year" class="form-control @error('tax_five_years') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="inspected">Inspected</label>
                                    <input type="date" name="inspected" id="inspected" class="form-control @error('inspected') is-invalid @enderror" required>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="origin">Origin</label>
                                    <input type="text" name="origin" id="origin" class="form-control @error('origin') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input type="file" name="photo" id="photo" class="form-control" placeholder="Select Photo">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="5"></textarea>
                                </div>
                            </div>
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
                    <form action="{{ route('types.store') }}" id="addVehiclesTypeForm" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Vehicle Type</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAddTypeVehicles()"><i class="fas fa-check"></i> Save</button>
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
                    <form action="{{ route('vehicles.assign') }}" method="post" id="assignVehiclesForm">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="vehicle_id" id="vehiclesId" required>
                            <label for="employee">Employee</label>
                            <select name="employee" id="employee" class="form-control">
                                <option value="" disabled selected>Select Employee</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->employe->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="assignment_date">Assingn Date</label>
                            <input type="date" name="assignment_date" id="assignment_date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAssignVehicles()"><i class="fas fa-check"></i> Save Asingn</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Transfer Vehicles -->
    <div class="modal fade" id="transferVehiclesModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transferModalLabel">Modal Transfer Vehicles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="transferVehiclesForm" method="post">
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
                        {{-- <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" name="file" id="file" class="form-control">
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmtransferVehicles()"><i class="fas fa-check"></i> Save transfer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Vehicles -->
    <div class="modal fade" id="updateVehiclesModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modal Edit Vehicles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('vehicles.update', ':id') }}" id="updateVehiclesForm" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <input type="text" name="brand" id="vehiclesBrand" class="form-control @error('brand') is-invalid @enderror" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <input type="text" name="model" id="vehiclesModel" class="form-control @error('model') is-invalid @enderror" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ownership">Ownership</label>
                                    <select name="ownership" id="vehiclesOwner" class="form-control @error('ownership') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Ownership</option>
                                        @foreach ($vehicleOwnerships as $ownership)
                                            <option value="{{ $ownership->id }}">{{ $ownership->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="license_plate">License Plate</label>
                                    <input type="text" name="license_plate" id="vehicleslicense" class="form-control @error('license_plate') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <input type="number" name="year" id="vehiclesYear" class="form-control @error('year') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <input type="text" name="color" id="vehiclesColor" class="form-control @error('color') is-invalid @enderror" required>
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vehicle_type">Vehicle Type</label>
                                    <select name="vehicle_type" id="vehiclesType" class="form-control @error('vehicle_type') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Vehicle Type</option>
                                        @foreach ($vehicleTypes as $vehicleType)
                                            <option value="{{ $vehicleType->id }}">{{ $vehicleType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="fuel">Fuel</label>
                                    <select name="fuel" id="vehiclesFuel" class="form-control @error('fuel') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Fuel</option>
                                        <option value="Gasoline">Gasoline</option>
                                        <option value="Diesel">Diesel</option>
                                    </select>
                                </div>   
                                <div class="form-group">
                                    <label for="purchase_price">Purchase Price</label>
                                    <input type="text" name="purchase_price" id="vehiclesPurchasePrice" class="form-control @error('purchase_price') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="purchase_date">Purchase Date</label>
                                    <input type="date" name="purchase_date" id="vehiclesPurchaseDate" class="form-control @error('purchase_date') is-invalid @enderror" required>
                                </div> 
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="transmission">Transmission</label>
                                    <select name="transmission" id="vehiclesTransmission" class="form-control @error('transmission') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Transmission</option>
                                        <option value="Automatic">Automatic</option>
                                        <option value="Manual">Manual</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tax_year">Tax Year</label>
                                    <input type="date" name="tax_year" id="vehiclesTaxYear" class="form-control @error('tax_year') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="tax_five_years">Tax Five Years</label>
                                    <input type="date" name="tax_five_year" id="vehiclesTaxFive" class="form-control @error('tax_five_years') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="inspected">Inspected</label>
                                    <input type="date" name="inspected" id="vehiclesInspected" class="form-control @error('inspected') is-invalid @enderror" required>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="origin">Origin</label>
                                    <input type="text" name="origin" id="vehiclesOrigin" class="form-control @error('origin') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input type="file" name="photo" id="vehiclesPhoto" class="form-control" placeholder="Select Photo">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="vehiclesDescription" class="form-control" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                        </div> 
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmVehiclesUpdate()"><i class="fas fa-check"></i> Save changes</button>
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
                    <form action="{{ route('types.update', ':id') }}" id="editVehiclesTypeForm" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Vehicle Type</label>
                            <input type="text" name="name" id="vehiclesTypeName" class="form-control @error('name') is-invalid @enderror" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="vehiclesTypeDescription" cols="30" rows="3"></textarea>
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
<script>
    function confirmAddVehicles() {
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
                $('#addVehiclesForm').submit();
            }
        })
    }

    function confirmAddTypeVehicles(){
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
                $('#addVehiclesTypeForm').submit();
            }
        })
    }

    function confirmAddVehicleOwner(){
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
                $('#addVehicleOwnerForm').submit();
            }
        })
    }

    $('#editVehiclesTypeModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var vehiclesTypeId = button.data('id');
        var vehiclesTypeName = button.data('name');
        var vehiclesTypeDescription = button.data('description');

        var modal = $(this);
        modal.find('.modal-body #vehiclesTypeName').val(vehiclesTypeName);
        modal.find('.modal-body #vehiclesTypeDescription').val(vehiclesTypeDescription);
        
        //replace action form
        var action = $('#editVehiclesTypeForm').attr('action');
        var newAction = action.replace(':id', vehiclesTypeId);
        $('#editVehiclesTypeForm').attr('action', newAction);
    })

    function confirmUpdateType() {
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
                $('#editVehiclesTypeForm').submit();
            }
        })
    }

    $('#editVehiclesOwnerModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var vehiclesOwnerId = button.data('id');
        var vehiclesOwnerName = button.data('name');

        var modal = $(this);
        modal.find('.modal-body #vehiclesOwnerName').val(vehiclesOwnerName);
        
        //replace action form
        var action = $('#editOwnerVehiclesForm').attr('action');
        var newAction = action.replace(':id', vehiclesOwnerId);
        $('#editOwnerVehiclesForm').attr('action', newAction);
    })

    function confirmUpdateOwner() {
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
                $('#editOwnerVehiclesForm').submit();
            }
        })
    }

    $('#updateVehiclesModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var vehiclesId = button.data('id');
        var vehiclesType = button.data('type');
        var vehiclesOwner = button.data('owner');
        var vehiclesTransmission = button.data('transmisi');
        var vehiclesOrigin = button.data('origin');
        var vehiclesName = button.data('name');
        var vehiclesBrand = button.data('brand');
        var vehiclesModel = button.data('model');
        var vehiclesColor = button.data('color');
        var vehiclesYear = button.data('year');
        var vehiclesFuel = button.data('fuel');
        var vehicleslicense = button.data('license_plate');
        var vehiclesTaxYear = button.data('tax_year');
        var vehiclesTaxFive = button.data('tax_five_year');
        var vehiclesInspected = button.data('inspected');
        var vehiclesPurchaseDate = button.data('purchase_date');
        var vehiclesPurchasePrice = button.data('purchase_price');
        var vehiclesPhoto = button.data('photo');
        var vehiclesDescription = button.data('description');
        
        
        var modal = $(this);
        modal.find('.modal-body #vehiclesType').val(vehiclesType).trigger('change');
        modal.find('.modal-body #vehiclesOwner').val(vehiclesOwner).trigger('change');
        modal.find('.modal-body #vehiclesTransmission').val(vehiclesTransmission).trigger('change');
        modal.find('.modal-body #vehiclesOrigin').val(vehiclesOrigin);
        modal.find('.modal-body #vehiclesName').val(vehiclesName);
        modal.find('.modal-body #vehiclesBrand').val(vehiclesBrand);
        modal.find('.modal-body #vehiclesModel').val(vehiclesModel);
        modal.find('.modal-body #vehiclesColor').val(vehiclesColor);
        modal.find('.modal-body #vehiclesYear').val(vehiclesYear);
        modal.find('.modal-body #vehiclesFuel').val(vehiclesFuel).trigger('change');
        modal.find('.modal-body #vehicleslicense').val(vehicleslicense);
        modal.find('.modal-body #vehiclesTaxYear').val(vehiclesTaxYear);
        modal.find('.modal-body #vehiclesTaxFive').val(vehiclesTaxFive);
        modal.find('.modal-body #vehiclesInspected').val(vehiclesInspected);
        modal.find('.modal-body #vehiclesPurchaseDate').val(vehiclesPurchaseDate);
        modal.find('.modal-body #vehiclesPurchasePrice').val(vehiclesPurchasePrice);
        // modal.find('.modal-body #vehiclesPhoto').val(vehiclesPhoto);
        modal.find('.modal-body #vehiclesDescription').val(vehiclesDescription);

        //replace action form
        var action = $('#updateVehiclesForm').attr('action');
        var newAction = action.replace(':id', vehiclesId);
        $('#updateVehiclesForm').attr('action', newAction);
    })

    function confirmVehiclesUpdate() {
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
                document.getElementById('updateVehiclesForm').submit();
            }
        })
    }    

    function confirmVehiclesDelete() {
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
                document.getElementById('deleteVehiclesForm').submit();
            }
        })
    }

    function confirmVehiclesTypeDelete() {
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
                document.getElementById('deleteVehiclesTypeForm').submit();
            }
        })
    }

    function confirmVehiclesOwnerDelete() {
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
                document.getElementById('deleteVehiclesOwnerForm').submit();
            }
        })
    }

    $('#assignVehiclesModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var vehiclesId = button.data('id');

        console.log(vehiclesId);
        
        var modal = $(this);
        document.getElementById('vehiclesId').value = vehiclesId;
    })

    function confirmAssignVehicles() {
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
                document.getElementById('assignVehiclesForm').submit();
            }
        })
    }
</script>
@endpush