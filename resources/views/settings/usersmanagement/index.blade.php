@extends('layouts.admin')

@push('css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Users Management</h1>
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
                    <span class="mx-2">to</span>
                    <input type="date" id="endDate" name="end_date" class="form-control mx-2 mb-2 w-auto" required>   
                    <!-- Tombol PDF dengan AJAX -->
                    {{-- <button type="button" onclick="printPDF()" class="btn btn-info btn-md ml-2">
                        <i class="fas fa-file-pdf fa-md white-50"></i> Print PDF
                    </button> --}}
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
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->fullName }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span class="badge badge-{{ $user->badgeClass }}">{{ $user->getRoleNames()[0] }}</span></td>
                                    <td class="text-center">
                                        <div class="d-inline-flex">
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info mr-2 btn-circle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($user->id !== auth()->user()->id)
                                            <button type="button" class="btn btn-warning mr-2 btn-circle"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-username="{{ $user->username }}"
                                                data-last_name="{{ $user->last_name }}"
                                                data-email="{{ $user->email }}"
                                                data-role="{{ $user->getRoleNames()[0] }}"
                                                data-company_id="{{ $user->employe->company_id }}"
                                                data-department_id="{{ $user->employe->department_id }}"
                                                data-branch_id="{{ $user->employe->branch_id }}"
                                                data-nik="{{ $user->employe->nik }}"
                                                data-full_name="{{ $user->fullName }}"
                                                data-phone="{{ $user->employe->phone }}"
                                                data-gender="{{ $user->employe->gender }}"
                                                data-age="{{ $user->employe->age }}"
                                                data-address="{{ $user->employe->address }}"
                                                data-position="{{ $user->employe->position }}"
                                                data-toggle="modal" data-target="#editUsersModal">
                                                <i class="fas fa-pencil"></i>
                                            </button>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="post" id="deleteUsersForm" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" onclick="confirmUsersDelete()" class="btn btn-danger btn-circle">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
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
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header text-primary">
                    <h5 class="modal-title" id="addModalLabel">Add Users & Employees</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="post" id="addUsersForm">
                        @csrf
                        <div class="form-group">
                            <label for="nik">Nik</label>
                            <input type="number" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">First Name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control @error('name') is-invalid @enderror" value="{{ old('first_name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input type="text" name="username" id="username" class="form-control @error('name') is-invalid @enderror" value="{{ old('username') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <select name="position" id="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}" required>
                                        <option value="" disabled selected>Select Position</option>
                                        <option value="admin">Admin</option>
                                        <option value="employee">Employee</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="company_id">Company</label>
                                    <select name="company_id" id="company_id" class="form-control @error('company_id') is-invalid @enderror">
                                        <option value="" disabled selected>Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="department_id">Department</label>
                                    <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror" value="{{ old('department_id') }}" required>
                                        <option value="" disabled selected>Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="branch_id">Branch</label>
                                    <select name="branch_id" id="branch_id" class="form-control @error('branch_id') is-invalid @enderror" value="{{ old('branch_id') }}" required>
                                        <option value="" disabled selected>Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input type="number" name="age" id="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" value="{{ old('gender') }}" required>
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
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
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" id="photo" class="form-control" placeholder="Select Photo">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control" cols="30" rows="4"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUsersAdd()"><i class="fas fa-check white-50"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editUsersModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header text-primary">
                    <h5 class="modal-title" id="editModalLabel">Update Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.update', ':id') }}" method="post" id="editUsersForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nik">Nik</label>
                            <input type="text" name="nik" id="nikEdit" class="form-control @error('nik') is-invalid @enderror" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">First Name</label>
                                    <input type="text" name="first_name" id="first_nameEdit" class="form-control @error('name') is-invalid @enderror" value="{{ old('first_name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input type="text" name="username" id="usernameEdit" class="form-control @error('name') is-invalid @enderror" value="{{ old('username') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <select name="position" id="positionEdit" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}" required>
                                        <option value="" disabled selected>Select Position</option>
                                        <option value="admin">Admin</option>
                                        <option value="employee">Employee</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="company_id">Company</label>
                                    <select name="company_id" id="company_idEdit" class="form-control @error('company_id') is-invalid @enderror">
                                        <option value="" disabled selected>Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="department_id">Department</label>
                                    <select name="department_id" id="department_idEdit" class="form-control @error('department_id') is-invalid @enderror" value="{{ old('department_id') }}" required>
                                        <option value="" disabled selected>Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="branch_id">Branch</label>
                                    <select name="branch_id" id="branch_idEdit" class="form-control @error('branch_id') is-invalid @enderror" value="{{ old('branch_id') }}" required>
                                        <option value="" disabled selected>Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" id="last_nameEdit" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="emailEdit" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password') is-invalid @enderror">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phoneEdit" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input type="number" name="age" id="ageEdit" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="genderEdit" class="form-control @error('gender') is-invalid @enderror" value="{{ old('gender') }}" required>
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="roles">Roles</label>
                                    <select name="roles" id="rolesEdit" class="form-control @error('roles') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Roles</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" id="photoEdit" class="form-control" placeholder="Select Photo">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="addressEdit" class="form-control" cols="30" rows="4"></textarea>
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
                <div class="modal-header text-primary">
                    <h5 class="modal-title" id="importModalLabel">Import Users</h5>
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
                    <button type="button" class="btn btn-primary" onclick="confirmImportUsers()"><i class="fas fa-file-import white-50"></i> Save</button>
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
        var usersName = button.data('username');
        var userLastName = button.data('last_name');
        var userEmail = button.data('email');
        var userRoles = button.data('role');
        var userCompany = button.data('company_id');
        var userDepartment = button.data('department_id');
        var userBranch = button.data('branch_id');
        var userNik = button.data('nik');
        var userFullName = button.data('full_name');
        var userPhone = button.data('phone');
        var userGender = button.data('gender');
        var userAge = button.data('age');
        var userAddress = button.data('address');
        var userPosition = button.data('position');
       
        var modal = $(this);
        modal.find('#first_nameEdit').val(userName);
        modal.find('#usernameEdit').val(usersName);
        modal.find('#last_nameEdit').val(userLastName);
        modal.find('#emailEdit').val(userEmail);
        modal.find('#rolesEdit').val(userRoles);
        modal.find('#company_idEdit').val(userCompany);
        modal.find('#department_idEdit').val(userDepartment);
        modal.find('#branch_idEdit').val(userBranch);
        modal.find('#nikEdit').val(userNik);
        modal.find('#full_nameEdit').val(userFullName);
        modal.find('#phoneEdit').val(userPhone);
        modal.find('#genderEdit').val(userGender);
        modal.find('#ageEdit').val(userAge);
        modal.find('#addressEdit').val(userAddress);
        modal.find('#positionEdit').val(userPosition);

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
</script>
@endpush