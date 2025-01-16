@extends('layouts.admin', [
    'title' => 'Create Bids Analysis'
])

@push('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
<h1 class="h3 mb-4 text-gray-800">Create Bids Analysis</h1>
<p class="mb-4">
    This page is used to create bids analysis.
</p>

<!-- List Bids Analysis -->
<div class="card shadow mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="m-0 font-weight-bold text-primary">Create Bids Analysis</h4>
            <a href="{{ route('bids-analysis.index') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-reply"></i> 
                Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('bids-analysis.store') }}" method="POST" id="bidForm">
                @csrf
                <!-- Bid Information -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Project Name</label>
                            <input type="text" class="form-control" name="project_name" value="{{ old('project_name') }}" placeholder="Project Name" required>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control" name="bid_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Number of Vendors Bids</label>
                            <select class="form-control" id="vendorCount" name="vendor_count">
                                <option value="2" selected>Bids 2 Vendors</option>
                                <option value="3">Bids 3 Vendors</option>
                                <option value="4">Bids 4 Vendors</option>
                                <option value="5">Bids 5 Vendors</option>
                            </select>
                        </div>
                    </div>
                </div>
    
                <!-- Vendor Names -->
                <div class="row mb-4" id="vendorNamesContainer">
                    <!-- Vendor name inputs will be dynamically added here -->
                </div>
    
                <!-- Items Table -->
                <div class="table-responsive mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="font-weight-bold">Items</h6>
                        <button type="button" class="btn btn-primary btn-sm m-1" id="addItem">
                            <i class="fas fa-cart-arrow-down mr-1"></i> Add Item
                        </button>
                    </div>
                    <table class="table table-bordered" id="bidsTable">
                        <thead>
                            <tr id="headerRow">
                                <th rowspan="2" class="align-middle">No</th>
                                <th rowspan="2" class="align-middle">Description</th>
                                <th rowspan="2" class="align-middle">QTY</th>
                                <th rowspan="2" class="align-middle">UOM</th>
                                <!-- Vendor columns will be added dynamically -->
                                <th rowspan="2" class="align-middle">Action</th>
                            </tr>
                            <tr id="subHeaderRow">
                                <!-- Price/Unit and Total columns will be added dynamically -->
                            </tr>
                        </thead>
                        <tbody id="itemsContainer">
                            <!-- Item rows will be added here -->
                        </tbody>
                        <tfoot id="tableFooter">
                            <!-- Footer rows will be added dynamically -->
                        </tfoot>
                    </table>
                </div>
            </form>
            <div class="float-right">
                <button type="button" class="btn btn-primary" onclick="confirmAddAnalysis()">
                    <i class="fas fa-save"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        let vendors = [];
        
        // Initialize the form
        function initializeForm() {
            const vendorCount = parseInt($('#vendorCount').val());
            vendors = [];
            
            // Clear existing vendor inputs
            $('#vendorNamesContainer').empty();
            
            // Add vendor name inputs
            for(let i = 0; i < vendorCount; i++) {
                const vendorInput = `
                    <div class="col-md-${12/vendorCount}">
                        <div class="form-group">
                            <label>Vendor ${i + 1} Name</label>
                            <input type="text" class="form-control vendor-name" 
                                name="vendor_names[]" 
                                data-vendor-index="${i}"
                                placeholder="Vendor ${i + 1} Name"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Vendor ${i + 1} Email</label>
                            <input type="email" class="form-control" 
                                name="vendor_emails[]"
                                placeholder="Vendor ${i + 1} Email"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Vendor ${i + 1} Phone</label>
                            <input type="text" class="form-control" 
                                name="vendor_phones[]"
                                placeholder="Vendor ${i + 1} Phone"
                                required>
                        </div>
                    </div>`;
                $('#vendorNamesContainer').append(vendorInput);
            }
            
            updateTableStructure();
            addInitialRow();
        }
        
        // Update table structure based on vendor count
        function updateTableStructure() {
            const vendorCount = parseInt($('#vendorCount').val());
            
            // Update vendors array
            vendors = Array.from($('.vendor-name')).map(input => ({
                name: input.value || `Vendor ${$(input).data('vendor-index') + 1}`,
                index: $(input).data('vendor-index')
            }));
            
            // Update header
            let headerHtml = `
                <th rowspan="2" class="align-middle">No</th>
                <th rowspan="2" class="align-middle">Description</th>
                <th rowspan="2" class="align-middle">QTY</th>
                <th rowspan="2" class="align-middle">UOM</th>`;
                
            let subHeaderHtml = '';
            
            vendors.forEach(vendor => {
                headerHtml += `<th colspan="2" class="text-center vendor-header-${vendor.index}">${vendor.name}</th>`;
                subHeaderHtml += `
                    <th class="text-center">Price/Unit</th>
                    <th class="text-center">Total</th>`;
            });
            
            headerHtml += '<th rowspan="2" class="align-middle">Action</th>';
            
            $('#headerRow').html(headerHtml);
            $('#subHeaderRow').html(subHeaderHtml);
            
            // Update footer structure
            updateFooterStructure();
        }
        
        // Update footer structure
        function updateFooterStructure() {
            let footerHtml = `
                <tr class="bg-light font-weight-bold">
                    <td colspan="4" class="text-right">TOTAL</td>`;
                    
            vendors.forEach(vendor => {
                footerHtml += `
                    <td colspan="2" id="vendor${vendor.index}-grand-total">
                        <input type="hidden" name="vendor${vendor.index}_grand_total">
                    </td>`;
            });
            
            footerHtml += '<td></td></tr>';
            
            // Add discount row
            footerHtml += `
                <tr>
                    <td colspan="4" class="text-right">DISCOUNT (%)</td>`;
                    
            vendors.forEach(vendor => {
                footerHtml += `
                    <td colspan="2">
                        <input type="number" class="form-control form-control-sm" 
                            name="vendor${vendor.index}_discount" placeholder="Discount (%)">
                    </td>`;
            });
            
            footerHtml += '<td></td></tr>';
            
            // Add final total row
            footerHtml += `
                <tr class="bg-light font-weight-bold">
                    <td colspan="4" class="text-right">TOTAL After Discount</td>`;
                    
            vendors.forEach(vendor => {
                footerHtml += `
                    <td colspan="2" id="vendor${vendor.index}-final-total">
                        <input type="hidden" name="vendor${vendor.index}_final_total" value="0" >
                    </td>`;
            });
            
            footerHtml += '<td></td></tr>';
            
            // Add terms of payment row
            footerHtml += `
                <tr>
                    <td colspan="4" class="text-right">Terms of Payment (Days)</td>`;
                    
            vendors.forEach(vendor => {
                footerHtml += `
                    <td colspan="2">
                        <input type="text" class="form-control form-control-sm" 
                            name="terms_of_payment_vendor${vendor.index}" placeholder="Terms of Payment (Days)">
                    </td>`;
            });
            
            footerHtml += '<td></td></tr>';
            
            // Add lead time row
            footerHtml += `
                <tr>
                    <td colspan="4" class="text-right">Lead Time (Days)</td>`;
                    
            vendors.forEach(vendor => {
                footerHtml += `
                    <td colspan="2">
                        <input type="text" class="form-control form-control-sm" 
                            name="lead_time_vendor${vendor.index}" placeholder="Lead Time (Days)">
                    </td>`;
            });
            
            footerHtml += '<td></td></tr>';
            
            $('#tableFooter').html(footerHtml);
        }
        
        // Add new item row
        function addInitialRow() {
            const newRow = createItemRow(0);
            $('#itemsContainer').html(newRow);
            calculateTotals();
        }
        
        function createItemRow(index) {
            let rowHtml = `
                <tr class="item-row">
                    <td>${index + 1}</td>
                    <td>
                        <input type="text" class="form-control form-control-sm" 
                            name="items[${index}][description]" placeholder="Item Description" required>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm quantity" 
                            name="items[${index}][quantity]" placeholder="Quantity" required>
                    </td>
                    <td>
                        <select class="form-control form-control-sm" name="items[${index}][uom]" required>
                            <option value="PCS">PCS</option>
                            <option value="UNIT">UNIT</option>
                            <option value="SET">SET</option>
                        </select>
                    </td>`;
            
            vendors.forEach(vendor => {
                rowHtml += `
                    <td>
                        <input type="number" class="form-control form-control-sm price vendor${vendor.index}-price" 
                            name="items[${index}][vendor${vendor.index}_price]" placeholder="Rp" required>
                    </td>
                    <td class="vendor${vendor.index}-total">0</td>`;
            });
            
            rowHtml += `
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btn-circle remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
                
            return rowHtml;
        }
        
        // Event Handlers
        $('#vendorCount').change(initializeForm);
        
        $(document).on('input', '.vendor-name', updateTableStructure);
        
        $('#addItem').click(function() {
            const rowCount = $('.item-row').length;
            const newRow = createItemRow(rowCount);
            $('#itemsContainer').append(newRow);
            calculateTotals();
        });
        
        $(document).on('click', '.remove-item', function() {
            if ($('.item-row').length > 1) {
                $(this).closest('tr').remove();

                // reset index for remaining rows
                $('.item-row').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                })
                calculateTotals();
            }
        });
        
        $(document).on('input', '.quantity, .price', calculateTotals);
        $(document).on('input', 'input[name$="_discount"]', calculateTotals);
        
        // Calculate totals
        function calculateTotals() {
            vendors.forEach(vendor => {
                let vendorTotal = 0;
                
                $('.item-row').each(function() {
                    const quantity = parseFloat($(this).find('.quantity').val()) || 0;
                    const price = parseFloat($(this).find(`.vendor${vendor.index}-price`).val()) || 0;
                    const rowTotal = quantity * price;
                    
                    $(this).find(`.vendor${vendor.index}-total`).text(rowTotal.toLocaleString());
                    vendorTotal += rowTotal;
                });
                
                // Update grand total text dan hidden input
                $(`#vendor${vendor.index}-grand-total`).text(vendorTotal.toLocaleString());
                
                // Cek apakah input hidden sudah ada
                if ($(`input[name="vendor${vendor.index}_grand_total"]`).length) {
                    // Update value jika sudah ada
                    $(`input[name="vendor${vendor.index}_grand_total"]`).val(vendorTotal);
                } else {
                    // Buat baru jika belum ada
                    $(`#vendor${vendor.index}-grand-total`).after(`
                        <input type="hidden" name="vendor${vendor.index}_grand_total" value="${vendorTotal}">
                    `);
                }
                
                const discount = parseFloat($(`input[name="vendor${vendor.index}_discount"]`).val()) || 0;
                const finalTotal = vendorTotal * (1 - discount/100);
                
                // Update final total text dan hidden input
                $(`#vendor${vendor.index}-final-total`).text(finalTotal.toLocaleString());
                
                // Cek apakah input hidden sudah ada
                if ($(`input[name="vendor${vendor.index}_final_total"]`).length) {
                    // Update value jika sudah ada
                    $(`input[name="vendor${vendor.index}_final_total"]`).val(finalTotal);
                } else {
                    // Buat baru jika belum ada
                    $(`#vendor${vendor.index}-final-total`).after(`
                        <input type="hidden" name="vendor${vendor.index}_final_total" value="${finalTotal}">
                    `);
                }
            });
        }

        initializeForm();
    });

    function confirmAddAnalysis() {
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to add this bid analysis?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Add',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#bidForm').submit();
                }
            });
        }
</script>
@endpush