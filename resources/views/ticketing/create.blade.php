@extends('layouts.admin')

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
                    
<!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Create Tickets</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.
    </p>

    <!-- Button modal create tickets -->
    <div class="row justify-content-center">
        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#exampleModal">
            Create Ticket
        </button>
    </div>
    
    <div class="card shadow mb-4 mt-4">
        <div class="card-body">
            <div class="row">
                @forelse ($tickets as $ticket)
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-{{ $ticket->badgeClass }} shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ $ticket->code }}</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $ticket->title }}
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            {{ $ticket->user->name }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <p>{{ $ticket->created_at->diffForHumans() }}</p>
                                    </div>
                                    <i class="fas fa-receipt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No tickets available.</p>
                @endforelse
            </div>
        </div>
    </div>
    
    

    <!-- Modal Create Tickets -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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