@extends('layouts.admin', [
    'title' => 'Bids Analysis Management'
])

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
<h1 class="h3 mb-4 text-gray-800">Bids Analysis Management</h1>
<p class="mb-4">
    This page is used to manage bids analysis.
</p>

<!-- List Bids Analysis -->
<div class="card shadow mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="m-0 font-weight-bold text-primary">List Bids Analysis</h4>
            <a href="{{ route('bids-analysis.create') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-chart-bar"></i> 
                Add Analysis
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center" width="15%">Code</th>
                            <th>Projetc Name</th>
                            <th class="text-center" width="15%">Date</th>
                            <th class="text-center" width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bids as $bid)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $bid->code }}</td>
                            <td>{{ $bid->project_name }}</td>
                            <td class="text-center">{{ Carbon\Carbon::parse($bid->date)->format('d-m-Y') }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <a href="{{ route('bids-analysis.exportPdf', $bid->id) }}" class="btn btn-success btn-circle mr-1">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('bids-analysis.show', $bid->id) }}" class="btn btn-info btn-circle mr-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('bids-analysis.edit', $bid->id) }}" class="btn btn-warning btn-circle mr-1">
                                        <i class="fas fa-pencil"></i>
                                    </a>
                                    <form action="{{ route('bids-analysis.destroy', $bid->id) }}" method="post" id="destroyBidForm-{{ $bid->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-circle" onclick="confirmDestroyBid({{ $bid->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No Data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Page level custom scripts  -->
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

    function confirmDestroyBid(bidId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You wont be delete this bids!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('destroyBidForm-' + bidId).submit();
            }
        })
    }
</script>
@endpush

@endsection