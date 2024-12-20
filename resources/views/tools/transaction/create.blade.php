@extends('layouts.admin')

@push('css')

<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ __('Create Delivery Note') }}</h1>
    <p class="mb-4">
        This page is used to create a delivery note for shipping or transferring goods.
    </p>

    <div class="card shadow mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Create Delivery Note</h6>
                <a href="{{ route('transactions.index') }}" class="btn btn-primary btn-md"><i class="fas fa-reply"></i> Back</a>
            </div>
            <div class="card-body">
                <!-- Form for Delivery Note -->
                <form action="{{ route('transactions.store') }}" method="POST" id="deliveryNoteForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="type_delivery">Type Delivery</label>
                                <select class="form-control" id="type_delivery" name="type_delivery" required>
                                    <option value="">-- Select Type Delivery --</option>
                                    <option value="Delivery Note">Delivery Note</option>
                                    <option value="Transfer">Transfer</option>
                                    <option value="Return">Return</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="driver_name">Driver Name</label>
                                <input type="text" class="form-control" id="driver_name" name="driver_name" placeholder="Enter driver name" required>
                            </div>
                            <!-- Source Project -->
                            <div class="form-group">
                                <label for="source_project_id">Source Project</label>
                                <select class="form-control" id="source_project_id" name="source_project_id" required>
                                    <option value="">-- Select Source Project --</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }} - {{ $project->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="driver_phone">Driver Phone</label>
                                <input type="text" class="form-control" id="driver_phone" name="driver_phone" placeholder="Enter driver phone" required>
                            </div>
                            <div class="d-flex justify-content-center">
                                <span><i class="fas fa-arrow-right fa-3x mt-4"></i></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="delivery_date">Delivery Note Date</label>
                                <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
                            </div>
                            <!-- Destination Project -->
                            <div class="form-group">
                                <label for="destination_project_id">Destination Project</label>
                                <select class="form-control" id="destination_project_id" name="destination_project_id" required>
                                    <option value="">-- Select Destination Project --</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }} - {{ $project->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-md-6">
                            <div id="reader" style="display:none;" class="text-center mb-3"></div>
                        </div>
                    </div>
                    <!-- Tools Selection -->
                    <div class="form-group">
                        <label for="tools">Select Tools</label>
                        <table class="table table-bordered" id="tools-table">
                            <thead>
                                <tr>
                                    <th>Tool</th>
                                    <th width="15%">Quantity</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary mt-2" id="add-row"><i class="fas fa-circle-plus"></i> Add Tool</button>
                        <button type="button" class="btn btn-info mt-2" id="add-row-scan" ><i class="fas fa-camera"></i> Add Tool Scan</button>
                    </div>

                    <!-- Notes -->
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Enter notes (optional)"></textarea>
                    </div>
                </form>
                <div class="float-right">    
                    <!-- Submit Button -->
                    <button type="button" class="btn btn-success" onclick="confirmAddTransaction()"><i class="fas fa-truck-moving"></i> Create Delivery Note</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.4/html5-qrcode.min.js"></script>
<script>
    let scannedItems = [];

    document.addEventListener('DOMContentLoaded', function () {
        const addRowBtn = document.getElementById('add-row');
        const addRowCam = document.getElementById('add-row-scan');
        const toolsTable = document.getElementById('tools-table').getElementsByTagName('tbody')[0];

        // Add row
        addRowBtn.addEventListener('click', function () {
            const newRow = toolsTable.insertRow();
            newRow.innerHTML = `
                <td>
                    <select class="form-control select2 tool-select" name="tools[]" required>
                        <option value="">-- Select Tool --</option>
                        @foreach ($tools as $tool)
                            <option value="{{ $tool->id }}" data-qty="{{ $tool->quantity }}">{{ $tool->name }} ({{ $tool->code }})</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control quantity-input" name="quantities[]" placeholder="Enter quantity" value="1" min="1" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-row"><i class="fas fa-trash"></i> Remove</button>
                </td>
            `;

            // Reinitialize Select2 for the newly added row
            initializeSelect2(newRow.querySelector('.select2'));

            // Add event listener for updating quantity
            const toolSelect = newRow.querySelector('.tool-select');
            const quantityInput = newRow.querySelector('.quantity-input');
            toolSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const quantity = selectedOption.getAttribute('data-qty');
                quantityInput.value = quantity;
            });

            // Add event listener to the remove button
            newRow.querySelector('.remove-row').addEventListener('click', function () {
                newRow.remove();
            });
        });

        // Add row scan barcode
        addRowCam.addEventListener('click', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async (position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    const location = await reverseGeocode(latitude, longitude);

                    startQrCodeScanner(location);
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });

        // Remove row
        toolsTable.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
            }
        });

        // Initialize Select2 for dynamically added rows
        function initializeSelect2(selectElement) {
            $(selectElement).select2({
                placeholder: "Select tools",
                allowClear: true
            });
        }

        async function reverseGeocode(lat, lon) {
            const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`;
            try {
                const response = await fetch(url);
                const data = await response.json();
                return data.display_name || `${lat}, ${lon}`;
            } catch (error) {
                console.error("Error during reverse geocoding:", error);
                return `${lat}, ${lon}`;
            }
        }

        function startQrCodeScanner(location) {
            const html5QrCode = new Html5Qrcode("reader");
            document.getElementById('reader').style.display = 'block';

            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                },
                (decodedText) => {
                    html5QrCode.stop().then(() => {
                        document.getElementById('reader').style.display = 'none';

                        scannedItems.push({ qr: decodedText, location });
                        // updateTable();
                    }).catch((err) => {
                        console.error("Error stopping QR scanner:", err);
                    });
                },
                (errorMessage) => {
                    console.error("Error scanning QR code:", errorMessage);
                }
            ).catch((err) => {
                console.error("Unable to start QR scanner:", err);
            });
        }
    });
</script>
<script>
    function confirmAddTransaction() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, create it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#deliveryNoteForm').submit();
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