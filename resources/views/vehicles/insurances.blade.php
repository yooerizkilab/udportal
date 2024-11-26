@extends('layouts.admin')

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> 
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Vehicles Insurances</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary">Vehicles Insurances</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- form add vehicle insurance -->
                        <div class="col-4">
                            <form action="" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="vehicle_code">Vehicle Code</label>
                                    <input type="text" class="form-control" id="vehicle_code" name="vehicle_code" placeholder="Enter Vehicle Code">
                                </div>
                                <div class="form-group">
                                    <label for="insurance_company">Insurance Company</label>
                                    <input type="text" class="form-control" id="insurance_company" name="insurance_company" placeholder="Enter Insurance Company">
                                </div>
                                <div class="form-group">
                                    <label for="policy_number">Policy Number</label>
                                    <input type="text" class="form-control" id="policy_number" name="policy_number" placeholder="Enter Policy Number">
                                </div>
                                <div class="form-group">
                                    <label for="premium">Premium</label>
                                    <input type="text" class="form-control" id="premium" name="premium" placeholder="Enter Premium">
                                </div>
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Enter Start Date">
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Enter End Date">
                                </div>
                            </form>
                            <div class="float-right mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
                                            <th>Insurance Number</th>
                                            <th>Insurance Company</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th width="10%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($insurances as $insurance)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $insurance->vehicle->code }}</td>
                                                <td>{{ $insurance->policy_number }}</td>
                                                <td>{{ $insurance->insurance_provider }}</td>
                                                <td>{{ $insurance->coverage_start }}</td>
                                                <td>{{ $insurance->coverage_end }}</td>
                                                <td class="text-center">
                                                    <div class="d-inline-flex">
                                                        <button type="button" class="btn btn-sm btn-info mr-1 btn-circle">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-warning mr-1 btn-circle">
                                                            <i class="fas fa-pencil"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger btn-circle">
                                                            <i class="fas fa-trash"></i>
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