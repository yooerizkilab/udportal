@extends('layouts.admin', [
    'title' => 'Bussines Master Management'
])

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush


@section('main-content')
<h1 class="h3 mb-4 text-gray-800">Bussines Master Management</h1>
<p class="mb-4">
    This page is used to manage bussines master.
</p>

<!-- List Bussines Master -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List Bussines Master</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        {{-- <th>#</th> --}}
                        <th>Card Code</th>
                        <th>Card Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
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
    $(document).ready(function () {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('bussines-master.index') }}',  // URL ke controller yang memanggil API
                type: 'GET',
                data: function(d) {
                    // Mengirimkan parameter tambahan ke server
                    d.search = d.search.value;  // Mengirimkan nilai pencarian (jika ada)
                }
            },
            columns: [
                { data: 'CardCode' },
                { data: 'CardName' },
                {
                    data: 'action',  // Kolom aksi untuk tombol detail
                    orderable: false,  // Tidak bisa disortir
                    searchable: false  // Tidak bisa dicari
                }
            ]
        });
    });
</script>
@endpush