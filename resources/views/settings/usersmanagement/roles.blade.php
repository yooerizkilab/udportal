@extends('layouts.admin')

@push('css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Role & Permission Management</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

    <div class="row">

        <div class="col-lg-6">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Role</h6>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addRoleModal">
                            <i class="fas fa-plus"></i> Add Role
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Name</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                <div class="d-inline-flex">
                                                    <button type="button" class="btn btn-info mr-1 btn-circle" data-toggle="modal" 
                                                            data-id="{{ $role->id }}" 
                                                            data-name="{{ $role->name }}" 
                                                            data-permissions="{{ $role->permissions->pluck('id')->join(',') }}" 
                                                            data-target="#viewRolePermissionModal">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @if ($role->name != 'Superadmin')
                                                        <button type="button" class="btn btn-warning mr-1 btn-circle" data-toggle="modal"
                                                            data-id="{{ $role->id }}"
                                                            data-name="{{ $role->name }}" 
                                                            data-target="#editRoleModal">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        <form action="{{ route('roles.destroy', $role->id) }}" method="post" id="deleteRoleForm" class="d-inline">
                                                            @csrf
                                                            <button type="button" onclick="confirmDeleteRole()" class="btn btn-danger btn-circle">
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

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Permission</h6>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPermissionModal">
                            <i class="fas fa-plus"></i> Add Permission
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Name</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($permissions as $permission)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td>
                                                <div class="d-inline-flex">
                                                    <button type="button" class="btn btn-warning mr-2 btn-circle" data-toggle="modal"
                                                        data-id="{{ $permission->id }}"
                                                        data-name="{{ $permission->name }}"
                                                        data-target="#editPermissionModal">
                                                        <i class="fas fa-pencil"></i>
                                                    </button>
                                                    <form action="" method="post" id="deletePermissionForm" class="d-inline">
                                                        @csrf
                                                        <button type="button" onclick="confirmPermissionDelete()" class="btn btn-danger btn-circle">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No Data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-gradient-warning text-white">
                    <h6 class="m-0 font-weight-bold">Assign Role to Permission</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.assignPermissions') }}" method="post" id="assignRoleToPermissionForm">
                        @csrf
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="" disabled selected>Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" data-permissions="{{ $role->permissions->pluck('id')->join(',') }}">
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <label for="permissions">Permissions</label>
                        <div class="row" id="permissionCheckboxes">
                            @foreach ($permissions as $permission)
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" id="permission{{ $permission->id }}" value="{{ $permission->id }}">
                                        <label class="form-check-label" for="permission{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                    <div class="float-right mt-3">
                        <button type="button" class="btn btn-primary" onclick="confirmAssignRoleToPermission()"><i class="fas fa-lock"></i> Assign Permissions</button>
                    </div>
                </div>
            </div>
        </div>
                
    </div>

    <!-- Modal Add Role -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('roles.store') }}" method="post" id="addRoleForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" required></textarea>
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" onclick="confirmAddRole()" class="btn btn-primary"> <i class="fas fa-check"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Role -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel">Modal Update Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('roles.update', ':id') }}" method="post" id="updateRoleForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="nameRole" class="form-control @error('name') is-invalid @enderror" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="descriptionRole" class="form-control" required></textarea>
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdateRole()"><i class="fas fa-check"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Role Permission -->
    <div class="modal fade" id="viewRolePermissionModal" tabindex="-1" aria-labelledby="viewRolePermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewRolePermissionModalLabel">Modal View Role Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Role Name</label>
                        <input type="text" name="name" id="nameRoleed" class="form-control" required readonly>
                    </div>
                    <label for="permissions">Permissions</label>
                    <div class="row" id="permissionCheckboxesModal">
                        @foreach ($permissions as $permission)
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" 
                                        id="permissions{{ $permission->id }}" value="{{ $permission->id }}" readonly>
                                    <label class="form-check-label" for="permissions{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Permission -->
    <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPermissionModalLabel">Modal Add Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('permissions.store') }}" method="post" id="addPermissionsForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" required></textarea>
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAddPermission()"><i class="fas fa-check"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Edit Permission -->
    <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPermissionModalLabel">Modal Update Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('permissions.update', ':id') }}" method="post" id="updatePermissionForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="namePermission" class="form-control" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" required></textarea>
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdatePermission()"><i class="fas fa-check"></i> Save changes</button>
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

    $(document).ready(function() {
        $('#dataTable1').DataTable();
    });

    // Pastikan script ini dijalankan setelah halaman selesai dimuat
    document.addEventListener("DOMContentLoaded", function () {
        // Pilih semua tombol yang akan membuka modal
        const modalButtons = document.querySelectorAll('button[data-toggle="modal"][data-target="#viewRolePermissionModal"]');
        const modalNameInput = document.getElementById('nameRoleed');
        const permissionCheckboxes = document.querySelectorAll('#permissionCheckboxesModal input[type="checkbox"]');

        // Fungsi untuk mengisi modal
        function populateModal(button) {
            // Ambil data dari tombol
            const roleName = button.getAttribute('data-name');
            const rolePermissions = button.getAttribute('data-permissions').split(',');            

            // Set nama role di modal
            modalNameInput.value = roleName;

            // Reset semua checkbox sebelum mengisi kembali
            permissionCheckboxes.forEach(checkbox => checkbox.checked = false);

            // Centang checkbox yang sesuai dengan permissions
            rolePermissions.forEach(permissionId => {
                const checkbox = document.getElementById(`permissions${permissionId}`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }

        // Menambahkan event listener pada setiap tombol
        modalButtons.forEach(button => {
            button.addEventListener('click', function () {
                populateModal(this); // Panggil fungsi untuk mengisi modal dengan data
            });
        });
    });

    function updateCheckboxPermissions(roleSelectId, checkboxContainerId) {
        // Ambil elemen dropdown dan container checkbox
        const roleSelect = document.getElementById(roleSelectId);
        const checkboxContainer = document.getElementById(checkboxContainerId);

        // Tambahkan event listener ke dropdown
        roleSelect.addEventListener('change', function () {
            // Ambil data-permissions dari opsi yang dipilih
            const selectedOption = this.options[this.selectedIndex];
            const permissions = selectedOption.getAttribute('data-permissions');

            // Dapatkan semua checkbox permissions dalam container
            const checkboxes = checkboxContainer.querySelectorAll('input[type="checkbox"]');

            // Uncheck semua checkbox terlebih dahulu
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            // Centang checkbox sesuai dengan permissions
            if (permissions) {
                const permissionIds = permissions.split(',');
                permissionIds.forEach(id => {
                    const checkbox = document.getElementById('permission' + id);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            }
        });
    }

    updateCheckboxPermissions('role', 'permissionCheckboxes');

    function confirmAddRole(){
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
                $('#addRoleForm').submit();
            } else {
                return false;
            }
        })
    }

    $('#editRoleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var roleId = button.data('id')
        var roleName = button.data('name');
        // var roleDescription = button.data('description');

        var modal = $(this);
        document.getElementById('nameRole').value = roleName;
        // document.getElementById('descriptionRole').value = roleDescription;
        
        // Ubah action form agar sesuai dengan id yang akan diupdate
        var formAction = '{{ route("roles.update", ":id") }}';
        formAction = formAction.replace(':id', roleId);
        console.log(formAction);
        modal.find('#updateRoleForm').attr('action', formAction);
    });
    

    function confirmUpdateRole(){
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
                $('#updateRoleForm').submit();
            } else {
                return false;
            }
        })
    }

    function confirmDeleteRole(){
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
                $('#deleteRoleForm').submit();
            } else {
                return false;
            }
        })
    }

    function confirmAddPermission() {
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
                document.getElementById('addPermissionsForm').submit();
            }else {
                return false;
            }
        });
    }

    $('#editPermissionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var permissionId = button.data('id')
        var permissionName = button.data('name');
        // var permissionDescription = button.data('description');

        var modal = $(this);
        document.getElementById('namePermission').value = permissionName;
        // document.getElementById('descriptionPermission').value = permissionDescription;
        
        // Ubah action form agar sesuai dengan id yang akan diupdate
        var formAction = '{{ route("permissions.update", ":id") }}';
        formAction = formAction.replace(':id', permissionId);
        modal.find('#updatePermissionForm').attr('action', formAction);
    });

    function confirmUpdatePermission(){
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
                document.getElementById('updatePermissionForm').submit();
            } else {
                return false;
            }
        })
    }

    function confirmPermissionDelete() {
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
                form.submit('#deletePermissionForm');
            } else {
                return false;
            }
        })
    }

    function confirmAssignRoleToPermission() {
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
                document.getElementById('assignRoleToPermissionForm').submit();
            } else {
                return false;
            }
        })
    }
</script>
@endpush