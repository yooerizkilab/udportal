@extends('layouts.admin')

@push('css')

<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ __('Tracking Tools') }}</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.
    </p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tracking</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Code</th>
                            <th>Tools</th>
                            <th>Location</th>
                            <th>Activity</th>
                            <th>Quantity</th>
                            <th>Type</th>
                            <th>Transaction Date</th>
                            {{-- <th width="10%" class="text-center">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($toolsTracking as $tracking)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tracking->tools->code }}</td>
                                <td>{{ $tracking->tools->name }}</td>
                                <td>{{ $tracking->location }}</td>
                                <td>{{ $tracking->activity }}</td>
                                <td>{{ $tracking->quantity }}</td>
                                <td><span class="badge badge-{{ $tracking->badgeClass }}">{{ $tracking->type }}</span></td>
                                <td>{{ date('d F Y', strtotime($tracking->transaction_date)) }}</td>
                                {{-- <td class="text-center">
                                    <div class="d-inline-flex">
                                        <a href="{{ route('tracking.show', $tracking->id) }}" class="btn btn-info btn-circle"><i class="fas fa-eye"></i></a>
                                    </div>
                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No data found</td>
                            </tr>
                        @endforelse
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