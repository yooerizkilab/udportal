@extends('layouts.admin')

@push('css')

<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
 
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ __('Delivery Note Transport') }}</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.
    </p>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Delivery Note Transport</h6>
            <form action="{{ route('dn-transport.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <button type="submit" class="btn btn-primary">Kirim Chat WA</button>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Delivery Note</th>
                            <th>Transport</th>
                            <th>Driver</th>
                            <th>Vehicle</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
<script>
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