@extends('layouts.admin')

@push('css')
   <!-- Custom styles for this page -->
   <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('main-content')
                    
<!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Create Tickets</h1>
    <p class="mb-4">
        This page is used to create tickets. Tickets are used to track issues and problems with the system.
    </p>

    <div class="row">
        <div class="col-md-5">
            <div class="card shadow mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-header py-3">
                        <h6 class="font-weight-bold text-primary">Create Tickets</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ticketing.store') }}" method="POST" id="addTicketForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="category_id">Categories Tickets</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="" disabled selected>Select Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="assignee_to">Associated To Departments</label>
                                <select name="assignee_to" id="assignee_to" class="form-control">
                                    <option value="" disabled selected>Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="priority">Priority</label>
                                <select class="form-control" id="priority" name="priority">
                                    <option value="" disabled selected>Select Priority</option>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
                            </div>
                            <div class="form-group">
                                <label for="description">Description Tickets</label>
                                <textarea id="summernote" name="description"></textarea>
                            </div>
                        </form>
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary" onclick="confirmAddTicket()">
                                <i class="fas fa-receipt"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">My Tickets</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Title</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th class="text-center" width="20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tickets as $ticket)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ticket->title }}</td>
                                            <td><span class="badge badge-{{ $ticket->priorityClass }}">{{ $ticket->priority }}</span></td>
                                            <td><span class="badge badge-{{ $ticket->badgeClass }}">{{ $ticket->status }}</span></td>
                                            <td class="text-center">
                                                <div class="d-inline-flex">
                                                    <a href="{{ route('ticketing.show', $ticket->id) }}" class="btn btn-info btn-circle mr-2">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if ($ticket->status != 'Closed' && $ticket->status == 'Open')
                                                    <button class="btn btn-warning btn-circle mr-2">
                                                        <i class="fas fa-pencil"></i>
                                                    </button>
                                                    @endif
                                                    @if ($ticket->status == 'Open')
                                                    <form action="{{ route('ticketing.destroy', $ticket->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-circle">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No data available</td>
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
<!-- Page level custom scripts  -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#summernote').summernote({
            height: 300,                 // Set height
            tabsize: 2,                  // Tab size
            placeholder: 'Write your content here...',
            toolbar: [
                // Custom toolbar options
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
        });
    });
</script>

<script>
    function confirmAddTicket() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, add it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('addTicketForm').submit();
            }
        })
    }

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