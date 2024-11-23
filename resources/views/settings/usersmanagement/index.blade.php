@extends('layouts.admin')

@push('css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                <div class="d-flex align-items-center flex-wrap">
                    <input type="date" id="startDate" name="start_date" class="form-control mr-2 mb-2 w-auto" required>
                    <input type="date" id="endDate" name="end_date" class="form-control mx-2 mb-2 w-auto" required>   
                    <!-- Tombol PDF dengan AJAX -->
                    <button type="button" onclick="printPDF()" class="btn btn-info btn-md ml-2">
                        <i class="fas fa-file-pdf fa-md white-50"></i> Print PDF
                    </button>
                    <!-- Tombol Excel dengan AJAX -->
                    <button type="button" onclick="printExcel()" class="btn btn-success btn-md ml-2">
                        <i class="fas fa-file-excel fa-md white-50"></i> Print Excel
                    </button>
                    
                    <!-- Tombol Import Data -->
                    <button type="button" class="btn btn-warning btn-md ml-2" data-toggle="modal" data-target="#importModal">
                        <i class="fas fa-file-import fa-md white-50"></i> Import Users
                    </button>
                    <!-- Tombol Add Users -->
                    <button type="button" class="btn btn-primary btn-md ml-2" data-toggle="modal" data-target="#addUsersModal">
                        <i class="fas fa-user-plus fa-md white-50"></i> Add Users
                    </button>
                </div>
            </div>    
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span class="badge badge-{{ $user->badgeClass }}">{{ $user->getRoleNames()[0] }}</span></td>
                                    <td>
                                        @if ($user->id !== auth()->user()->id)
                                            <div class="d-inline-flex">
                                                <button type="button" class="btn btn-info mr-2 btn-circle" 
                                                    data-name="{{ $user->name }}"
                                                    data-last_name="{{ $user->last_name }}"
                                                    data-email="{{ $user->email }}"
                                                    data-role="{{ $user->getRoleNames()[0] }}"   
                                                    data-toggle="modal" data-target="#viewUsersModal">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-warning mr-2 btn-circle"
                                                    data-id="{{ $user->id }}"
                                                    data-name="{{ $user->name }}"
                                                    data-last_name="{{ $user->last_name }}"
                                                    data-email="{{ $user->email }}"
                                                    data-role="{{ $user->getRoleNames()[0] }}"
                                                    data-toggle="modal" data-target="#editUsersModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="post" id="deleteUsersForm" class="d-inline">
                                                    @csrf
                                                    <button type="button" onclick="confirmUsersDelete()" class="btn btn-danger btn-circle">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>                        
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View -->
    <div class="modal fade" id="viewUsersModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">Modal View Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="nameUsers" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_nameUsers" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="emailUsers" class="form-control" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="roles">Roles</label>
                        <input type="text" name="roles" id="rolesUsers" class="form-control" required readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addUsersModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Modal Add Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="post" id="addUsersForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="roles">Roles</label>
                            <select name="roles" id="roles" class="form-control @error('roles') is-invalid @enderror" required>
                                <option value="" disabled selected>Select Roles</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUsersAdd()"><i class="fas fa-check white-50"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editUsersModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.update', ':id') }}" method="post" id="editUsersForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <input type="hidden" name="id" id="Usersid">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="Usersname" class="form-control @error('name') is-invalid @enderror" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" id="Userslast_name" class="form-control @error('last_name') is-invalid @enderror" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="Usersemail" class="form-control @error('email') is-invalid @enderror" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="roles">Roles</label>
                            <select name="roles" id="roles" class="form-control @error('roles') is-invalid @enderror" required>
                                <option value="" selected disabled>Select Roles</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUsersUpdate()"><i class="fas fa-check white-50"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Modal Import Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" id="importUsresForm">
                        @csrf
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" required accept=".xlsx, .xls, .csv">
                            <p class="text-danger">*Format file .xlsx .xls .csv</p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmImportUsers()"><i class="fas fa-file-import white-50"></i> Save changes</button>
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

<script>
    $('#viewUsersModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var userName = button.data('name');
        var userLastName = button.data('last_name');
        var userEmail = button.data('email');
        var userRoles = button.data('role');
       
        var modal = $(this);
        document.getElementById('nameUsers').value = userName;
        document.getElementById('last_nameUsers').value = userLastName;
        document.getElementById('emailUsers').value = userEmail;
        document.getElementById('rolesUsers').value = userRoles;
    })

    function printPDF() {
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;
        if(startDate && endDate) {
            $.ajax({
                url: "",
                method: "GET",
                data: {
                    'start_date': startDate,
                    'end_date': endDate
                },
                success: function(data) {
                    window.open(data, '_blank');
                }
            })
        }
    }

    function printExcel() {
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;
        if(startDate && endDate) {
            $.ajax({
                url: "",
                method: "GET",
                data: {
                    'start_date': startDate,
                    'end_date': endDate
                },
                success: function(data) {
                    window.open(data, '_blank');
                }
            })
        }
    }

    function confirmUsersAdd() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#addUsersForm').submit();
            } else {
                return false;
            }
        })
    }

    $('#editUsersModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var userId = button.data('id')
        var userName = button.data('name');
        var userLastName = button.data('last_name');
        var userEmail = button.data('email');
        var userRoles = button.data('role');

        var modal = $(this);
        document.getElementById('Usersid').value = userId;
        document.getElementById('Usersname').value = userName;
        document.getElementById('Userslast_name').value = userLastName;
        document.getElementById('Usersemail').value = userEmail;

        // Ubah action form agar sesuai dengan id yang akan diupdate
        var formAction = '{{ route("users.update", ":id") }}';
        formAction = formAction.replace(':id', userId);
        $('#editUsersForm').attr('action', formAction);
    })
    
    function confirmUsersUpdate() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#editUsersForm').submit();
            } else {
                return false;
        }})
    }

    function confirmUsersDelete() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit('deleteUsersForm');
            } else {
                return false;
        }})
    }

    function confirmImportUsers() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#importUsresForm').submit();
            } else {
                return false;
            }
        })
    }

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        })
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        })
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ $errors->first() }}',
        })
    @endif
</script>
@endpush