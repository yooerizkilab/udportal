@extends('layouts.admin')

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')

    <h1 class="h3 mb-4 text-gray-800">{{ __('Ticketing Management') }}</h1>

    <!-- Ticket Widget -->
    @if(auth()->user()->role != 'user')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Ticket Open</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['open'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-info">
                                <i class="fas fa-receipt fa-2x text-gray-300"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Ticket In Progress</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['inprogress'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-secondary">
                                <i class="fas fa-receipt fa-2x text-gray-300"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ticket Closed</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['closed'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-success">
                                <i class="fas fa-receipt fa-2x text-gray-300"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ticket Cancelled</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['cancelled'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger">
                                <i class="fas fa-receipt fa-2x text-gray-300"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif                 

    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3 d-flex bg-gradient-primary align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-white">Tickets</h6>
            {{-- <button type="button" class="btn btn-success " data-toggle="modal" data-target="#exampleModal">
                Create Ticket
            </button> --}}
            <a href="{{ route('ticketing.create') }}" class="btn btn-success">
                Create Ticket
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse ($tickets as $ticket)
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-{{ $ticket->badgeClass }} shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="d-flex justify-content-between">
                                        <!-- Ticket Code -->
                                        <div class="text-xs font-weight-bold text-uppercase mb-2">
                                            <a href="{{ route('ticketing.show', $ticket->id) }}" class="text-primary text-800">{{ $ticket->code }}</a>
                                        </div> 
                                        <!-- Ticket Priority -->
                                        <p class="mb-0">
                                            <span class="badge badge-{{ $ticket->priorityClass }} text-capitalize">
                                                {{ $ticket->priority }}
                                            </span>
                                        </p>
                                    </div>
                                    <!-- Ticket Title -->
                                    {{-- @if() --}}
                                    <h6 class="h5 font-weight-bold text-gray-800 mb-1">
                                        <a href="{{ route('ticketing.show', $ticket->id) }}" class="text-dark text-800">{{ strlen($ticket->title) > 10 ? substr($ticket->title, 0, 10) . '...' : $ticket->title }}</a>
                                    </h6> 
                                    {{-- @endif        --}}
                                    <!-- User Name -->
                                    <p class="text-gray-700 mb-1">
                                        <i class="fas fa-user mr-1"></i> {{ $ticket->user->name }}
                                    </p>
                                    <!-- User Department -->
                                    <p class="text-gray-700 mb-1">
                                        <i class="fas fa-building mr-1"></i> {{ $ticket->department->name }}
                                    </p>
                                    <!-- Ticket Status -->
                                    <p class="mb-0">
                                        <span class="badge badge-{{ $ticket->badgeClass }} text-capitalize">
                                            {{ $ticket->status }}
                                        </span>
                                    </p>                         
                                </div>
                                <!-- Action Section -->
                                <div class="col-auto text-center">
                                    <p class="text-muted small mb-2">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </p>
                                    <a href="{{ route('ticketing.show', $ticket->id) }}" class="btn btn-{{ $ticket->badgeClass }} btn-sm" aria-label="View Ticket">
                                        <i class="fas fa-receipt fa-lg text-gray-300"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <p class="text-center text-muted">No tickets available.</p>
                @endforelse
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $tickets->links('pagination::bootstrap-4') }}
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
