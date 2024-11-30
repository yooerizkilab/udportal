@extends('layouts.admin')

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> 
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Vehicles Details</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.
    </p>

    <!-- Card Example -->
    <div class="card shadow mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Vehicles Details</h6>
                <a href="{{ route('vehicles.index') }}" class="btn btn-primary btn-md"><i class="fas fa-reply"></i> Back</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mt-4 mb-3">
                            <img 
                                src="https://auto2000.co.id/berita-dan-tips/_next/image?url=https%3A%2F%2Fastradigitaldigiroomuat.blob.core.windows.net%2Fstorage-uat-001%2Fmobil-mpv-adalah.jpg&w=3840&q=75" 
                                class="img-fluid rounded shadow-sm border border-primary w-100">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="text-center mb-4">
                            <h3 class="font-weight-bold text-primary">Specification Car</h3>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <span class="font-weight-bold text-muted">Name</span>
                                    <span>Toyota Camry</span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <span class="font-weight-bold text-muted">Model</span>
                                    <span>Sedan</span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <span class="font-weight-bold text-muted">Year</span>
                                    <span>2023</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <span class="font-weight-bold text-muted">Type</span>
                                    <span>Luxury</span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <span class="font-weight-bold text-muted">Transmission</span>
                                    <span>Automatic</span>
                                </div>
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <span class="font-weight-bold text-muted">Fuel Type</span>
                                    <span>Petrol</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center mb-4">
                            <h3 class="font-weight-bold text-primary">Description</h3>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos, nihil.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center mb-4">
                            <h3 class="font-weight-bold text-primary">Price</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="" alt="">
                            </div>
                            <div class="col-md-4">
                                <img src="" alt="">
                            </div>
                            <div class="col-md-4">
                                <img src="" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center mb-4">
                            <h3 class="font-weight-bold text-primary">Gallery</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="" alt="">
                            </div>
                            <div class="col-md-4">
                                <img src="" alt="">
                            </div>
                            <div class="col-md-4">
                                <img src="" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center mb-4">
                            <h3 class="font-weight-bold text-primary">Documents</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="" alt="">
                            </div>
                            <div class="col-md-4">
                                <img src="" alt="">
                            </div>
                            <div class="col-md-4">
                                <img src="" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center mb-4">
                            <h3 class="font-weight-bold text-primary">History Car</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Ownership</th>
                                                <th>Purchase Price</th>
                                                <th>Purchase Date</th>
                                                <th>Selling Price</th>
                                                <th>Selling Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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