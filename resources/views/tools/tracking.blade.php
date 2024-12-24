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
                            <th width="10%">Code</th>
                            <th width="15%">Tools</th>
                            <th class="text-center">Last Location</th>
                            <th width="25%" class="text-center">Activity</th>
                            <th>Transaction Date</th>
                            {{-- <th width="10%" class="text-center">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trackings as $tracking)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tracking->tools->code ?? 'N/A' }}</td>
                                <td>{{ $tracking->tools->name ?? 'N/A' }}</td>
                                <td>{{ $tracking->last_location ?? 'N/A' }}</td>
                                <td><span class="badge badge-{{ $tracking->badgeClass }}">{{ $tracking->type ?? 'N/A' }}</span> : {{ $tracking->sourceTransactions->name ?? 'N/A' }} <i class="fas fa-arrow-right text-primary"></i> {{ $tracking->destinationTransactions->name ?? 'N/A' }}</td>
                                <td>{{ date('d M Y', strtotime($tracking->created_at)) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Data Not Found</td>
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
@endpush