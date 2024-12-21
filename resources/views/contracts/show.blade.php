@extends('layouts.admin')

@push('css')

<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Contracts Details</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.
    </p>

    <!-- Card Example -->
    <div class="card shadow mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="m-0 font-weight-bold text-primary">Contract Details</h4>
                <a href="{{ route('contract.index') }}" class="btn btn-primary btn-md mr-2"><i class="fas fa-reply"></i> Back</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $contract->id }}</td>
                            </tr>
                            <tr>
                                <th>Code</th>
                                <td>{{ $contract->code }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $contract->name }}</td>
                            </tr>
                            <tr>
                                <th>Company Name</th>
                                <td>{{ $contract->nama_perusahaan }}</td>
                            </tr>
                            <tr>
                                <th>Job Name</th>
                                <td>{{ $contract->nama_pekerjaan }}</td>
                            </tr>
                            <tr>
                                <th>Contract Status</th>
                                <td>{{ $contract->status_kontrak }}</td>
                            </tr>
                            <tr>
                                <th>Job Type</th>
                                <td>{{ $contract->jenis_pekerjaan }}</td>
                            </tr>
                            <tr>
                                <th>Contract Value</th>
                                <td>{{ $contract->mata_uang }} {{ $contract->nominal_kontrak }}</td>
                            </tr>
                            <tr>
                                <th>Contract Date</th>
                                <td>{{ $contract->tanggal_kontrak }}</td>
                            </tr>
                            <tr>
                                <th>Validity Period</th>
                                <td>{{ $contract->masa_berlaku }}</td>
                            </tr>
                            <tr>
                                <th>Project Status</th>
                                <td>{{ $contract->status_proyek }}</td>
                            </tr>
                            <tr>
                                <th>Retention</th>
                                <td>{{ $contract->retensi }}</td>
                            </tr>
                            <tr>
                                <th>Retention Period</th>
                                <td>{{ $contract->masa_retensi }}</td>
                            </tr>
                            <tr>
                                <th>Retention Status</th>
                                <td>{{ $contract->status_retensi }}</td>
                            </tr>
                            <tr>
                                <th>PIC Sales</th>
                                <td>{{ $contract->pic_sales }}</td>
                            </tr>
                            <tr>
                                <th>PIC PC</th>
                                <td>{{ $contract->pic_pc }}</td>
                            </tr>
                            <tr>
                                <th>PIC Customer</th>
                                <td>{{ $contract->pic_customer }}</td>
                            </tr>
                            <tr>
                                <th>Currency</th>
                                <td>{{ $contract->mata_uang }}</td>
                            </tr>
                            <tr>
                                <th>BAST 1</th>
                                <td>{{ $contract->bast_1 }}</td>
                            </tr>
                            <tr>
                                <th>BAST 1 Number</th>
                                <td>{{ $contract->bast_1_nomor }}</td>
                            </tr>
                            <tr>
                                <th>BAST 2</th>
                                <td>{{ $contract->bast_2 }}</td>
                            </tr>
                            <tr>
                                <th>BAST 2 Number</th>
                                <td>{{ $contract->bast_2_nomor }}</td>
                            </tr>
                            <tr>
                                <th>Overall Status</th>
                                <td>{{ $contract->overall_status }}</td>
                            </tr>
                            <tr>
                                <th>Contract Owner</th>
                                <td>{{ $contract->kontrak_milik }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $contract->keterangan }}</td>
                            </tr>
                            <tr>
                                <th>Memo</th>
                                <td>{{ $contract->memo }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

@endpush