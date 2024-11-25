@extends('layouts.admin')

@push('css')
   <!-- Custom styles for this page -->
   <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
                    
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tools Management</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

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
                    <button type="button" class="btn btn-warning btn-md ml-2 mb-2" data-toggle="modal" data-target="#importToolsModal">
                        <i class="fas fa-file-import fa-md white-50"></i> Import Tools
                    </button>
                    <!-- Tombol Add Users -->
                    <button type="button" class="btn btn-primary btn-md ml-2 mb-2" data-toggle="modal" data-target="#addToolsModal">
                        <i class="fas fa-wrench fa-md white-50"></i> Add Tools
                    </button>
                </div>
            </div> 
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Code</th>
                                <th>Serial Number</th>
                                <th>Name</th>
                                <th>Condition</th>
                                <th>Status</th>
                                <th width="10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tools as $tool)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tool->code }}</td>
                                    <td>{{ $tool->serial_number }}</td>
                                    <td>{{ $tool->name }}</td>
                                    <td>{{ $tool->condition }}</td>
                                    <td><span class="badge badge-{{ $tool->badgeClass }}">{{ $tool->status }}</span></td>
                                    <td>
                                        <div class="d-inline-flex">
                                            <button type="button" class="btn btn-info mr-1 btn-circle"
                                                data-toggle="modal"
                                                data-id="{{ $tool->id }}"
                                                data-owner="{{ $tool->owner_id }}"
                                                data-categorie="{{ $tool->categerie_id }}"
                                                data-code="{{ $tool->code }}"
                                                data-serial="{{ $tool->serial_number }}"
                                                data-name="{{ $tool->name }}"
                                                data-brand="{{ $tool->brand }}"
                                                data-type="{{ $tool->type }}"
                                                data-model="{{ $tool->model }}"
                                                data-year="{{ $tool->year }}"
                                                data-origin="{{ $tool->origin }}"
                                                data-condition="{{ $tool->condition }}"
                                                data-status="{{ $tool->status }}"
                                                data-target="#viewToolsModal">
                                                <i class="fas fa-eye fa-md white-50"></i>
                                            </button>
                                            <button type="button" class="btn btn-secondary mr-1 btn-circle"
                                                data-toggle="modal"
                                                data-id="{{ $tool->id }}"
                                                data-target="#transferToolsModal">
                                                <i class="fas fa-exchange fa-md white-50"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning mr-1 btn-circle"
                                                data-toggle="modal"
                                                data-id="{{ $tool->id }}"
                                                data-owner="{{ $tool->owner_id }}"
                                                data-categorie="{{ $tool->categorie->name }}"
                                                data-code="{{ $tool->code }}"
                                                data-serial="{{ $tool->serial_number }}"
                                                data-name="{{ $tool->name }}"
                                                data-brand="{{ $tool->brand }}"
                                                data-type="{{ $tool->type }}"
                                                data-model="{{ $tool->model }}"
                                                data-year="{{ $tool->year }}"
                                                data-origin="{{ $tool->origin }}"
                                                data-condition="{{ $tool->condition }}"
                                                data-quantity="{{ $tool->stock->quantity }}"
                                                data-unit="{{ $tool->stock->unit }}"
                                                data-status="{{ $tool->status }}"
                                                data-target="#editToolsModal">
                                                <i class="fas fa-pencil fa-md white-50"></i>
                                            </button>
                                            <form action="{{ route('tools.destroy', $tool->id) }}" method="post" id="formDeleteTools">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger mr-1 btn-circle" onclick="confirmToolsDelete()">
                                                    <i class="fas fa-trash fa-md white-50"></i>
                                                </button>
                                            </form>
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

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Tools Categories</h6>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
                            <i class="fas fa-list fa-md white-50"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th class="text-center" width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($toolsCategories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->code }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td class="text-center">
                                                <div class="d-inline-flex">
                                                    <button type="button" class="btn btn-warning mr-1 btn-circle"
                                                        data-toggle="modal"
                                                        data-id="{{ $category->id }}"
                                                        data-code="{{ $category->code }}"
                                                        data-name="{{ $category->name }}"
                                                        data-description="{{ $category->description }}"
                                                        data-target="#editCategoryModal">
                                                        <i class="fas fa-pencil fa-md white-50"></i>
                                                    </button>
                                                    <form action="{{ route('categories.destroy', $category->id) }}" method="post" id="deleteCategoryForm" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="confirmDeleteCategory()" class="btn btn-danger btn-circle">
                                                            <i class="fas fa-trash fa-md white-50"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Tools Ownership</h6>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addOwnershipModal">
                            <i class="fas fa-user-plus fa-md white-50"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Owners</th>
                                        <th class="text-center" width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($toolsOwnership as $ownership)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ownership->name }}</td>
                                            <td>
                                                <div class="d-inline-flex">
                                                    <button type="button" class="btn btn-info mr-1 btn-circle"
                                                        data-toggle="modal"
                                                        data-id="{{ $ownership->id }}" 
                                                        data-name="{{ $ownership->name }}"
                                                        data-address="{{ $ownership->address }}"
                                                        data-phone="{{ $ownership->phone }}"
                                                        data-target="#viewOwnerModal">
                                                        <i class="fas fa-eye fa-md white-50"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-warning mr-1 btn-circle"
                                                        data-toggle="modal"
                                                        data-id="{{ $ownership->id }}" 
                                                        data-name="{{ $ownership->name }}"
                                                        data-address="{{ $ownership->address }}"
                                                        data-phone="{{ $ownership->phone }}"
                                                        data-target="#editOwnershipModal">
                                                        <i class="fas fa-pencil fa-md white-50"></i>
                                                    </button>
                                                    <form action="{{ route('owners.destroy', $ownership->id) }}" method="post" id="deleteOwnershipForm" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="confirmOwnershipDelete()" class="btn btn-danger btn-circle">
                                                            <i class="fas fa-trash fa-md white-50"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No data available</td>
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

    <!-- Modal View Tools -->
    <div class="modal fade" id="viewToolsModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Modal View Tools</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Owners Tools -->
    <div class="modal fade" id="viewOwnerModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Modal View Owner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="ownerName" readonly>
                    <input type="text" class="form-control" id="ownerAddress" readonly>
                    <input type="text" class="form-control" id="ownerPhone" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Category Tools -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Modal Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('categories.store') }}" method="post" id="addCategoryForm">
                        @csrf
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="4"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAddCategory()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Owner Tools -->
    <div class="modal fade" id="addOwnershipModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Modal Add Owner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('owners.store') }}" method="post" id="addOwnerForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"" cols="30" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAddOwner()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Tools -->
    <div class="modal fade" id="addToolsModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Modal Add Tools</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tools.store') }}" method="post" id="addToolsForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ownership">Ownership</label>
                                    <select name="ownership" id="ownership" class="form-control @error('ownership') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Ownership</option>
                                        @foreach ($toolsOwnership as $ownership)
                                            <option value="{{ $ownership->id }}">{{ $ownership->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="categories">Categories</label>
                                    <select name="categories" id="categories" class="form-control @error('categories') is-invalid @enderror">
                                        <option value="" disabled selected>Select Categories</option>
                                        @foreach ($toolsCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <input type="text" name="brand" id="brand" class="form-control @error('brand') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="condition">Condition</label>
                                    <select name="condition" id="condition" class="form-control @error('condition') is-invalid @enderror">
                                        <option value="" disabled selected>Select Condition</option>
                                        <option value="Good">Good</option>
                                        <option value="Used">Used</option>
                                        <option value="Broken">Broken</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="origin">Origin</label>
                                    <input type="text" name="origin" id="origin" class="form-control @error('origin') is-invalid @enderror" value="{{ old('origin') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="serial_number">Serial Number</label>
                                    <input type="text" name="serial_number" id="serial_number" class="form-control @error('serial_number') is-invalid @enderror" value="{{ old('serial_number') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <input type="text" name="model" id="model" class="form-control @error('model') is-invalid @enderror" value="{{ old('model') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <input type="date" name="year" id="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <select name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror">
                                        <option value="" disabled selected>Select Unit</option>
                                        <option value="Pcs">Pcs</option>
                                        <option value="Set">Set</option>
                                        <option value="Rol">Rol</option>
                                        <option value="Unit">Unit</option>☻
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <option value="In Active">In Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAddTools()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Category Tools -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editModalLable" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLable">Modal Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('categories.update', ':id') }}" method="post" id="updateCategoryForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="codeEdit" name="code" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameEdit" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="descriptionEdit" class="form-control" cols="30" rows="4"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdateCategory()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Owner Tools -->
    <div class="modal fade" id="editOwnershipModal" tabindex="-1" aria-labelledby="editModalLable" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLable">Modal Edit Owner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('owners.update', ':id') }}" method="post" id="updateOwnerForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameEditOwner" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="addressEditOwner" class="form-control" cols="30" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phoneEditOwner" name="phone" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdateOwner()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Tools -->
    <div class="modal fade" id="editToolsModal" tabindex="-1" aria-labelledby="editModalLable" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLable">Modal Edit Tools</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tools.update', ':id') }}" method="post" id="updateToolsForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="ownership">Ownership</label>
                            <select name="ownership" id="ownershipEdit" class="form-control @error('ownership') is-invalid @enderror" required>
                                <option value="" disabled selected>Select Ownership</option>
                                @foreach ($toolsOwnership as $ownership)
                                    <option value="{{ $ownership->id }}">{{ $ownership->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="codeToolsEdit" class="form-control @error('code') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="nameToolsEdit" class="form-control @error('name') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="categories">Categories</label>
                                    <select name="categories" id="categoriesEdit" class="form-control @error('categories') is-invalid @enderror">
                                        <option value="" disabled selected>Select Categories</option>
                                        @foreach ($toolsCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <input type="text" name="brand" id="brandToolsEdit" class="form-control @error('brand') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <input type="text" name="type" id="typeToolsEdit" class="form-control @error('type') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="condition">Condition</label>
                                    <select name="condition" id="conditionEdit" class="form-control @error('condition') is-invalid @enderror">
                                        <option value="" disabled selected>Select Condition</option>
                                        <option value="Good">Good</option>
                                        <option value="Used">Used</option>
                                        <option value="Broken">Broken</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="serial_number">Serial Number</label>
                                    <input type="text" name="serial_number" id="serialToolsEdit" class="form-control @error('serial_number') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <input type="text" name="model" id="modelToolsEdit" class="form-control @error('model') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <input type="date" name="year" id="yearToolsEdit" class="form-control @error('year') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" id="quantityToolsEdit" class="form-control @error('quantity') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <select name="unit" id="unitToolsEdit" class="form-control @error('unit') is-invalid @enderror">
                                        <option value="" disabled selected>Select Unit</option>
                                        <option value="Pcs">Pcs</option>
                                        <option value="Set">Set</option>
                                        <option value="Rol">Rol</option>
                                        <option value="Unit">Unit</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="statusToolsEdit" class="form-control @error('status') is-invalid @enderror">
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <option value="In Active">In Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdateTools()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Transfer Tools -->
    <div class="modal fade" id="transferToolsModal" tabindex="-1" aria-labelledby="transferModalLable" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transferModalLable">Modal Transfer Tools</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tools.transfer') }}" method="post" id="transferToolsForm">
                        @csrf
                        <input type="hidden" name="tools_id" id="toolsId">
                        <div class="form-group">
                            <label for="from">From</label>
                            <input type="text" name="from" id="from" class="form-control @error('from') is-invalid @enderror">
                        </div>
                        <div class="text-center">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <div class="form-group">
                            <label for="to">To</label>
                            <input type="text" name="to" id="to" class="form-control @error('to') is-invalid @enderror">
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror">
                        </div>
                        <div class="form-group">
                            <label for="notes">Note</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" cols="30" rows="4"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmTransferTools()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import Tools -->
    <div class="modal fade" id="importToolsModal" tabindex="-1" aria-labelledby="importModalLable" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLable">Modal Import Tools</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="importToolsForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required>
                            <p class="text-danger">*Format file .xlsx .xls .csv</p></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmImportTools()"><i class="fas fa-check"></i> Save</button>
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
        $('#dataTable').DataTable({
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        });
    });
    $(document).ready(function() {
        $('#dataTable1').DataTable({
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        });
    })
    $(document).ready(function() {
        $('#dataTable2').DataTable();
    })
</script>

<script>

    $('#viewOwnerModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var ownerName = button.data('name');
        var ownerAddress = button.data('address');
        var ownerPhone = button.data('phone');

        var modal = $(this);
        document.getElementById('ownerName').value = ownerName;
        document.getElementById('ownerAddress').value = ownerAddress;
        document.getElementById('ownerPhone').value = ownerPhone;
    });

    $('#viewToolsModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var toolsId = button.data('id');

        var modal = $(this);
    });

    function confirmAddCategory() {
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
                $('#addCategoryForm').submit();
            }
        });
    }

    function confirmAddOwner() {
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
                $('#addOwnerForm').submit();
            }
        });
    }

    function confirmAddTools() {
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
                $('#addToolsForm').submit();
            }
        });
    }

    $('#editCategoryModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var categoryId = button.data('id')
        var categoryCode = button.data('code')
        var categoryName = button.data('name');
        var categoryDescription = button.data('description');

        var modal = $(this);
        document.getElementById('codeEdit').value = categoryCode;
        document.getElementById('nameEdit').value = categoryName;
        document.getElementById('descriptionEdit').value = categoryDescription;

        var FormAction = '{{ route("categories.update", ":id") }}';
        FormAction = FormAction.replace(':id', categoryId);
        $('#updateCategoryForm').attr('action', FormAction);
    });

    function confirmUpdateCategory() {
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
                $('#updateCategoryForm').submit();
            }
        });
    }

    $('#editOwnershipModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var ownerId = button.data('id')
        var ownerName = button.data('name');
        var ownerAddress = button.data('address');
        var ownerPhone = button.data('phone');

        var modal = $(this);
        document.getElementById('nameEditOwner').value = ownerName;
        document.getElementById('addressEditOwner').value = ownerAddress;
        document.getElementById('phoneEditOwner').value = ownerPhone;

        var FormAction = '{{ route("owners.update", ":id") }}';
        FormAction = FormAction.replace(':id', ownerId);
        $('#updateOwnerForm').attr('action', FormAction);
    })

    function confirmUpdateOwner() {
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
                $('#updateOwnerForm').submit();
            }
        });
    }

    $('#editToolsModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var toolsId = button.data('id')
        var toolsOwner = button.data('owner')
        var toolsCategorie = button.data('categorie')
        var toolsCode = button.data('code')
        var toolsSerial = button.data('serial')
        var toolsName = button.data('name')
        var toolsBrand = button.data('brand')
        var toolsType = button.data('type')
        var toolsModel = button.data('model')
        var toolsYear = button.data('year')
        var toolsOrigin = button.data('origin')
        var toolsQuantity = button.data('quantity')
        var toolsUnit = button.data('unit')
        var toolsCondition = button.data('condition')
        var toolsStatus = button.data('status')

        var modal = $(this);
    
        // console.log(toolsCategorie);
        
        var select = document.getElementById('ownershipEdit');
        for (var i = 0; i < select.options.length; i++) {
            if (select.options[i].value == toolsOwner) {
                select.options[i].selected = true;
            }
        }
        
        document.getElementById('codeToolsEdit').value = toolsCode;
        document.getElementById('serialToolsEdit').value = toolsSerial;
        document.getElementById('nameToolsEdit').value = toolsName;
        document.getElementById('modelToolsEdit').value = toolsModel;

        var select1 = document.getElementById('categoriesEdit');
        for (var i = 0; i < select1.options.length; i++) {
            if (select1.options[i].value == toolsCategorie) {
                select1.options[i].selected = true;
            }
        }
        
        document.getElementById('yearToolsEdit').value = toolsYear;
        document.getElementById('brandToolsEdit').value = toolsBrand;
        document.getElementById('typeToolsEdit').value = toolsType;
        document.getElementById('quantityToolsEdit').value = toolsQuantity

        var select2 = document.getElementById('unitToolsEdit');
        for (var i = 0; i < select2.options.length; i++) {
            if (select2.options[i].value == toolsUnit) {
                select2.options[i].selected = true;
            }
        }

        var select3 = document.getElementById('conditionEdit');
        for (var i = 0; i < select3.options.length; i++) {
            if (select3.options[i].value == toolsCondition) {
                select3.options[i].selected = true;
            }
        }

        var select4 = document.getElementById('statusToolsEdit');
        for (var i = 0; i < select4.options.length; i++) {
            if (select4.options[i].value == toolsStatus) {
                select4.options[i].selected = true;
            }
        }

        // var select5 = document.getElementById('categoriesEdit');
        // for (var i = 0; i < select5.options.length; i++) {
        //     if (select5.options[i].value == toolsCategorie) {
        //         select5.options[i].selected = true;
        //     }
        // }

        var FormAction = '{{ route("tools.update", ":id") }}';
        FormAction = FormAction.replace(':id', toolsId);
        $('#updateToolsForm').attr('action', FormAction);
    })
    
    function confirmUpdateTools() {
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
                $('#updateToolsForm').submit();
            }
        });
    }

    function confirmDeleteCategory() {
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
                $('#deleteCategoryForm').submit();
            }
        });
    }

    function confirmOwnershipDelete() {
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
                $('#deleteOwnershipForm').submit();
            }
        });
    }

    function confirmToolsDelete() {
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
                $('#formDeleteTools').submit();
            }
        });
    }

    $('#transferToolsModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var toolsId = button.data('id')
        var modal = $(this);
        document.getElementById('toolsId').value = toolsId;
    });

    function confirmTransferTools() {
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
                $('#transferToolsForm').submit();
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