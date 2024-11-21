@extends('layouts.admin')

@push('css')

<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  
@endpush

@section('main-content')
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Contracts Management</h1>
        <a href="{{ route('contract.index') }}" class="btn btn-primary btn-md mr-2"><i class="fas fa-reply"></i> Back</a>
    </div>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.
    </p>

    <!-- Card Example -->
    <div class="card shadow mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Contracts Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <td>{{ $response['Code'] }}</td>
                        <br>
                        <td>{{ $response['Name'] }}</td>
                        <br>
                        <td>{{ $response['U_CardName'] }}</td>
                        <br>
                        <td>{{ $response['U_PrjName'] }}</td>
                        <br>
                        <td>{{ $response['U_ContrSts'] }}</td>
                        <br>
                        <td>{{ $response['U_JobTyp'] }}</td>
                        <br>
                        <td>{{ $response['U_ContrAmt'] }}</td>
                    </div>
                    <div class="col-md-6">
                        <td>{{ $response['U_ContrStart'] }}</td>
                        <br>
                        <td>{{ $response['U_ValidPrd'] }}</td>
                        <br>
                        <td>{{ $response['U_PrjSts'] }}</td>
                        <br>
                        <td>{{ $response['U_ContrCurr'] }}</td>
                        <br>
                        <td>{{ $response['U_Company'] }}</td>
                        <br>
                        <td>{{ $response['U_Remark'] }}</td>
                        <br>
                        <td>{{ $response['U_Memo'] }}</td>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

@endpush