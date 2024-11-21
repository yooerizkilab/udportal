@extends('layouts.admin')

@push('css')

<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  
@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Contracts Management</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="m-0 font-weight-bold text-primary">List Contracts</h6>
                <div class="d-flex align-items-center flex-wrap">
                    <input type="date" id="startDate" name="start_date" class="form-control mr-2 mb-2 w-auto" required>
                    <input type="date" id="endDate" name="end_date" class="form-control mx-2 mb-2 w-auto" required>   
                    <!-- Tombol PDF dengan AJAX -->
                    <button type="button" onclick="printPDF()" class="btn btn-info btn-md ml-2 mb-2">
                        <i class="fas fa-file-pdf fa-md white-50"></i> Print PDF
                    </button>
                    <!-- Tombol Excel dengan AJAX -->
                    <button type="button" onclick="printExcel()" class="btn btn-success btn-md ml-2 mb-2">
                        <i class="fas fa-file-excel fa-md white-50"></i> Print Excel
                    </button>
                    <!-- Dropdown Filter -->
                    <div class="dropdown ml-2 mb-2">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-filter fa-md white-50"></i> Filter
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                    <!-- Tombol Import Data Contracts -->
                    <button type="button" class="btn btn-warning btn-md ml-2 mb-2" data-toggle="modal" data-target="#importContractsModal">
                        <i class="fas fa-file-import fa-md white-50"></i> Import Contracts
                    </button>
                    <!-- Tombol Add Contracts -->
                    <button type="button" class="btn btn-primary btn-md ml-2 mb-2" data-toggle="modal" data-target="#addContractsModal">
                        <i class="fas fa-file-contract fa-md white-50"></i> Add Contracts
                    </button>
                </div>
            </div> 
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Name Company</th>
                                {{-- <th>Worker/Project Name</th>
                                <th>Type Contract</th>
                                <th>Type of Work</th>

                                <th>Status</th>
                                <th>Currency</th>
                                <th>Price</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Owned Contract</th>
                                <th>Description</th>
                                <th>Memo</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($response as $contract)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $contract['Code'] }}</td>
                                    <td>{{ $contract['Name'] }}</td>
                                    <td>{{ $contract['U_CardName'] }}</td>
                                    {{-- <td>{{ $contract['U_PrjName'] }}</td>
                                    <td>{{ $contract['U_ContrSts'] }}</td>
                                    <td>{{ $contract['U_JobTyp'] }}</td>
                                    <td>{{ $contract['U_PrjSts'] }}</td>
                                    <td>{{ $contract['U_ContrCurr'] }}</td>
                                    <td>{{ $contract['U_ContrAmt'] }}</td>
                                    <td>{{ $contract['U_ContrStart'] }}</td>
                                    <td>{{ $contract['U_ValidPrd'] }}</td>
                                    <td>{{ $contract['U_Company'] }}</td>
                                    <td>{{ $contract['U_Remark'] }}</td>
                                    <td>{{ $contract['U_Memo'] }}</td> --}}
                                    <td class="text-center">
                                        <div class="d-inline-flex">
                                            <a href="{{ route('contract.show', str_replace('/', '%20', $contract['Code'])) }}" class="btn btn-info btn-sm mr-2 btn-circle"><i class="fas fa-eye"></i></a>
                                            <button type="button" class="btn btn-warning btn-sm mr-2 btn-circle" 
                                                data-code="{{ $contract['Code'] }}"
                                                data-name="{{ $contract['Name'] }}"
                                                data-company="{{ $contract['U_CardName'] }}"
                                                data-project="{{ $contract['U_PrjName'] }}"
                                                data-status="{{ $contract['U_ContrSts'] }}"
                                                data-type="{{ $contract['U_JobTyp'] }}"
                                                data-projectstatus="{{ $contract['U_PrjSts'] }}"
                                                data-currency="{{ $contract['U_ContrCurr'] }}"
                                                data-price="{{ $contract['U_ContrAmt'] }}"
                                                data-startdate="{{ $contract['U_ContrStart'] }}"
                                                data-enddate="{{ $contract['U_ValidPrd'] }}"
                                                data-ownedcontract="{{ $contract['U_Company'] }}"
                                                data-description="{{ $contract['U_Remark'] }}"
                                                data-memo="{{ $contract['U_Memo'] }}"
                                                data-toggle="modal" 
                                                data-target="#editContractsModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="16" class="text-center">No Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--- Modal Add Contracts --->
    <div class="modal fade" id="addContractsModal" tabindex="-1" role="dialog" aria-labelledby="addContractsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addContractsModalLabel">Modal Add Contracts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('contract.store') }}" method="post" id="addContractsForm">
                        @csrf
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" name="code" id="code" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="name_company">Name Company</label>
                            <input type="text" name="name_company" id="name_company" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="worker_project">Worker / Project Name</label>
                            <input type="text" name="worker_project" id="worker_project" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type_contract">Type Contract</label>
                                    <select name="type_contract" id="type_contract" class="form-control">
                                        <option value="" disabled selected>Select Type Contract</option>
                                        <option value="DO">DO</option>
                                        <option value="PO">PO</option>
                                        <option value="SPB">SPB</option>
                                        <option value="SPK">SPK</option>
                                        <option value="MOU">MOU</option>
                                        <option value="NDA">NDA</option>
                                        <option value="ADD-1">ADD-1</option>
                                        <option value="ADD-2">ADD-2</option>
                                        <option value="ADD-3">ADD-3</option>
                                        <option value="ADDENDUM-1">ADDENDUM-1</option>
                                        <option value="ADDENDUM-2">ADDENDUM-2</option>
                                        <option value="ADDENDUM-3">ADDENDUM-3</option>
                                        <option value="CONTRACT">CONTRACT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="currency">Currency</label>
                                    <select name="currency" id="currency" class="form-control" required>
                                        <option value="" disabled selected>Select Currency</option>
                                        <option value="USD">USD</option>
                                        <option value="IDR">IDR</option>
                                        <option value="EUR">EUR</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="owned_contract">Owned Contract</label>
                                    <input type="text" name="owned_contract" id="owned_contract" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type_work">Type of Work</label>
                                    <select name="type_work" id="type_work" class="form-control">
                                        <option value="" disabled selected>Select Type of Work</option>
                                        <option value="PENGADAAN">PENGADAAN</option>
                                        <option value="PEMASANGAN">PEMASANGAN</option>
                                        <option value="KONSULTASI">KONSULTASI</option>
                                        <option value="PERBAIKAN">PERBAIKAN</option>
                                        <option value="JASA">JASA</option> 
                                        <option value="SEWA">SEWA</option>
                                        <option value="KERJASAMA">KERJASAMA</option>
                                        <option value="LAINNYA">LAINNYA</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" id="price" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="OPEN">OPEN</option>
                                        <option value="CLOSED">CLOSSED</option>
                                        <option value="PENDING">PENDING</option>
                                        <option value="CANCELLED">CANCELLED</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="memo">Memo</label>
                            <textarea name="memo" id="memo" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                        {{-- <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" name="file" id="file" class="form-control">
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmAddContracts()"><i class="fas fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Contracts -->
    <div class="modal fade" id="editContractsModal" tabindex="-1" role="dialog" aria-labelledby="editContractsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editContractsModalLabel">Modal Edit Contracts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('contract.update', ':id') }}" method="post" id="updateContractsForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" name="code" id="codeEdit" class="form-control @error('code') is-invalid @enderror" required readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="nameEdit" class="form-control @error('name') is-invalid @enderror" required>
                        </div>
                        <div class="form-group">
                            <label for="name_company">Name Company</label>
                            <input type="text" name="name_company" id="name_companyEdit" class="form-control @error('name_company') is-invalid @enderror" required>
                        </div>
                        <div class="form-group">
                            <label for="worker_project">Worker / Project Name</label>
                            <input type="text" name="worker_project" id="worker_projectEdit" class="form-control @error('worker_project') is-invalid @enderror" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type_contract">Type Contract</label>
                                    <select name="type_contract" id="type_contractEdit" class="form-control @error('type_contract') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Type Contract</option>
                                        <option value="DO">DO</option>
                                        <option value="PO">PO</option>
                                        <option value="SPB">SPB</option>
                                        <option value="SPK">SPK</option>
                                        <option value="MOU">MOU</option>
                                        <option value="NDA">NDA</option>
                                        <option value="ADD-1">ADD-1</option>
                                        <option value="ADD-2">ADD-2</option>
                                        <option value="ADD-3">ADD-3</option>
                                        <option value="ADDENDUM-1">ADDENDUM-1</option>
                                        <option value="ADDENDUM-2">ADDENDUM-2</option>
                                        <option value="ADDENDUM-3">ADDENDUM-3</option>
                                        <option value="KONTRAK">KONTRAK</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="currency">Currency</label>
                                    <select name="currency" id="currencyEdit" class="form-control @error('currency') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Currency</option>
                                        <option value="USD">USD</option>
                                        <option value="IDR">IDR</option>
                                        <option value="EUR">EUR</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" id="start_dateEdit" class="form-control @error('start_date') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="owned_contract">Owned Contract</label>
                                    <input type="text" name="owned_contract" id="owned_contractEdit" class="form-control @error('owned_contract') is-invalid @enderror" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type_work">Type of Work</label>
                                    <select name="type_work" id="type_workEdit" class="form-control @error('type_work') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Type of Work</option>
                                        <option value="-">-</option>
                                        <option value="PENGADAAN">PENGADAAN</option>
                                        <option value="PEMASANGAN">PEMASANGAN</option>
                                        <option value="KONSULTASI">KONSULTASI</option>
                                        <option value="PERBAIKAN">PERBAIKAN</option>
                                        <option value="JASA">JASA</option> 
                                        <option value="SEWA">SEWA</option>
                                        <option value="KERJASAMA">KERJASAMA</option>
                                        <option value="CO LICENSING">CO LICENSING</option>
                                        <option value="LAINNYA">LAINNYA</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" id="priceEdit" class="form-control @error('price') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" id="end_dateEdit" class="form-control @error('end_date') is-invalid @enderror" required>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="statusEdit" class="form-control @error('status') is-invalid @enderror">
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="OPEN">OPEN</option>
                                        <option value="CLOSED">CLOSSED</option>
                                        <option value="PENDING">PENDING</option>
                                        <option value="CANCELLED">CANCELLED</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="descriptionEdit" class="form-control" cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="memo">Memo</label>
                            <textarea name="memo" id="memoEdit" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                        {{-- <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" name="file" id="file" class="form-control">
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdateContracts()"><i class="fas fa-check"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import Contracts -->
    <div class="modal fade" id="importContractsModal" tabindex="-1" role="dialog" aria-labelledby="importContractsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importContractsModalLabel">Modal Import Contracts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmImportContracts()"><i class="fas fa-check"></i> Save</button>
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
            $('#dataTable').DataTable(
                {
                    "order": [[ 0, "asc" ]]
                }
            );
        });
    </script>

    <script>

        function confirmAddContracts() {
            // Konfirmasi pengguna sebelum menyimpan data
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
                    document.getElementById('addContractsForm').submit();
                } else {
                    return false;
                }
            })
        }

        function confirmUpdateContracts() {
            // Konfirmasi pengguna sebelum menyimpan data
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
                    document.getElementById('updateContractsForm').submit();
                } else {
                    return false;
                }
            })
        }

        $('#editContractsModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var contractCode = button.data('code');
            var contractName = button.data('name');
            var contractNameCompany = button.data('company');
            var contractWorkerProject = button.data('project');
            var contractStatus = button.data('status');
            var contractTypeWork = button.data('type');
            var contractProjetStatus = button.data('projectstatus');
            var contractCurrency = button.data('currency');
            var contractAmount = button.data('price');
            var contractStartDate = button.data('startdate');
            var contractEndDate = button.data('enddate');
            var contractOwnedContract = button.data('ownedcontract');
            var contractDescription = button.data('description');
            var contractMemo = button.data('memo');

            var modal = $(this);
            document.getElementById('codeEdit').value = contractCode;
            document.getElementById('nameEdit').value = contractName;
            document.getElementById('name_companyEdit').value = contractNameCompany;
            document.getElementById('worker_projectEdit').value = contractWorkerProject;

            var select = document.getElementById('type_contractEdit');
            for (var i = 0; i < select.options.length; i++) {
                if (select.options[i].value == contractStatus) {
                    select.options[i].selected = true;
                }
            }

            // select option selected
            var select1 = document.getElementById('statusEdit');
            for (var i = 0; i < select1.options.length; i++) {
                if (select1.options[i].value == contractProjetStatus) {
                    select1.options[i].selected = true;
                }
            }
   
            // select option selected
            var select3 = document.getElementById('type_workEdit');
            for (var i = 0; i < select3.options.length; i++) {
                if (select3.options[i].value == contractTypeWork) {
                    select3.options[i].selected = true;
                }
            }

            // select option selected
            var select2 = document.getElementById('currencyEdit');
            for (var i = 0; i < select2.options.length; i++) {
                if (select2.options[i].value == contractCurrency) {
                    select2.options[i].selected = true;
                }
            }

            document.getElementById('priceEdit').value = contractAmount;
            document.getElementById('start_dateEdit').value = contractStartDate;
            document.getElementById('end_dateEdit').value = contractEndDate;
            document.getElementById('owned_contractEdit').value = contractOwnedContract;
            document.getElementById('descriptionEdit').value = contractDescription;
            document.getElementById('memoEdit').value = contractMemo;

            // condition if contractCode contains '/' 
            if (typeof contractCode === "string" && contractCode.includes('/')) {
                // Replace the contractCode
                var id = contractCode.replace(/\//g, '%20');
            } else {
                var id = contractCode; // Jika tidak ada '/', id tetap sama
            }
            // Ubah action form agar sesuai dengan id yang akan diupdate
            var formAction = '{{ route("contract.update", ":id") }}';
            formAction = formAction.replace(':id', id);
            $('#updateContractsForm').attr('action', formAction);
        })

        function confirmImportContracts() {
            // Konfirmasi pengguna sebelum menyimpan data
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
                    document.getElementById('importContractsForm').submit();
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
                showConfirmButton: false,
                timer: 1500
            })
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                showConfirmButton: true,
                // timer: 1500
            })
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ $errors->first() }}',
                showConfirmButton: true,
                // timer: 1500
            })
        @endif

    </script>
@endpush