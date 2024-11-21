@extends('layouts.admin')

@push('css')
  
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
                        <!-- image vehicle -->
                        <div class="col-6">
                            {{-- <img src="{{ asset('img/vehicle.png') }}" class="img-fluid" alt="vehicle"> --}}
                            <div class="border p-3">
                                <img src="https://imgcdn.oto.com/medium/gallery/exterior/38/2707/toyota-innova-zenix-hybrid-ev-front-angle-low-view-239610.jpg" class="img-fluid" style="width: 100%" alt="vehicle">
                            </div>
                        </div>
                        <!-- form add vehicle insurance -->
                        <div class="col-6">
                            <form action="" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="insurance_number">Insurance Number</label>
                                    <input type="text" class="form-control" id="insurance_number" name="insurance_number" placeholder="Enter Insurance Number">
                                </div>
                                <div class="form-group">
                                    <label for="insurance_company">Insurance Company</label>
                                    <input type="text" class="form-control" id="insurance_company" name="insurance_company" placeholder="Enter Insurance Company">
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
                    </div>
                </div> 
            </div>
        </div>
    </div>
    

@endsection

@push('scripts')

@endpush