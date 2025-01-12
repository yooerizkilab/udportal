@extends('layouts.admin', [
    'title' => 'Create Bids Analysis'
])

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
<h1 class="h3 mb-4 text-gray-800">Create Bids Analysis</h1>
<p class="mb-4">
    This page is used to create bids analysis.
</p>

<!-- List Bids Analysis -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Create Bids Analysis</h6>
    </div>
    <div class="card-body">
        <form action="" method="POST" id="bidForm">
            @csrf
            <!-- Bid Information -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Bid Number</label>
                        <input type="text" class="form-control" name="bid_number" value="UDMW/I/2024" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" class="form-control" name="bid_date" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Company</label>
                        <input type="text" class="form-control" name="company_name" placeholder="Enter company name" required>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="table-responsive mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="font-weight-bold">Items</h6>
                    <button type="button" class="btn btn-primary btn-sm m-3" id="addItem">
                        <i class="fas fa-plus-circle mr-1"></i> Add Item
                    </button>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2" class="align-middle">No</th>
                            <th rowspan="2" class="align-middle">Description</th>
                            <th rowspan="2" class="align-middle">QTY</th>
                            <th rowspan="2" class="align-middle">UOM</th>
                            <th colspan="2" class="text-center">PT BCD</th>
                            <th colspan="2" class="text-center">PT XYZ</th>
                            <th colspan="2" class="text-center">PT PQR</th>
                            <th rowspan="2" class="align-middle">Action</th>
                        </tr>
                        <tr>
                            <th class="text-center">Price/Unit</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Price/Unit</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Price/Unit</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody id="itemsContainer">
                        <tr class="item-row">
                            <td>1</td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="items[0][description]" required>
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm quantity" name="items[0][quantity]" required>
                            </td>
                            <td>
                                <select class="form-control form-control-sm" name="items[0][uom]" required>
                                    <option value="pcs">PCS</option>
                                    <option value="unit">Unit</option>
                                    <option value="set">Set</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm price vendor1-price" name="items[0][vendor1_price]" required>
                            </td>
                            <td class="vendor1-total">0</td>
                            <td>
                                <input type="number" class="form-control form-control-sm price vendor2-price" name="items[0][vendor2_price]" required>
                            </td>
                            <td class="vendor2-total">0</td>
                            <td>
                                <input type="number" class="form-control form-control-sm price vendor3-price" name="items[0][vendor3_price]" required>
                            </td>
                            <td class="vendor3-total">0</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-item">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-light font-weight-bold">
                            <td colspan="4" class="text-right">TOTAL</td>
                            <td colspan="2" id="vendor1-grand-total">0</td>
                            <td colspan="2" id="vendor2-grand-total">0</td>
                            <td colspan="2" id="vendor3-grand-total">0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">DISCOUNT (%)</td>
                            <td colspan="2">
                                <input type="number" class="form-control form-control-sm" name="vendor1_discount" value="0">
                            </td>
                            <td colspan="2">
                                <input type="number" class="form-control form-control-sm" name="vendor2_discount" value="0">
                            </td>
                            <td colspan="2">
                                <input type="number" class="form-control form-control-sm" name="vendor3_discount" value="0">
                            </td>
                            <td></td>
                        </tr>
                        <tr class="bg-light font-weight-bold">
                            <td colspan="4" class="text-right">TOTAL After Discount</td>
                            <td colspan="2" id="vendor1-final-total">0</td>
                            <td colspan="2" id="vendor2-final-total">0</td>
                            <td colspan="2" id="vendor3-final-total">0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Terms of Payment (Days)</td>
                            <td colspan="2">
                                <input type="text" class="form-control form-control-sm" name="terms_of_payment_vendor1">
                            </td>
                            <td colspan="2">
                                <input type="text" class="form-control form-control-sm" name="terms_of_payment_vendor2">
                            </td>
                            <td colspan="2">
                                <input type="text" class="form-control form-control-sm" name="terms_of_payment_vendor3">
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Lead Time (Days)</td>
                            <td colspan="2">
                                <input type="text" class="form-control form-control-sm" name="lead_time_vendor1">
                            </td>
                            <td colspan="2">
                                <input type="text" class="form-control form-control-sm" name="lead_time_vendor2">
                            </td>
                            <td colspan="2">
                                <input type="text" class="form-control form-control-sm" name="lead_time_vendor3">
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </form>
        <div class="float-right">
            <button type="button" class="btn btn-primary" id="addItem">
                <i class="fas fa-plus"></i> Submit
            </button>
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
    // Add new item row
    $('#addItem').click(function() {
        const rowCount = $('.item-row').length;
        const newRow = $('.item-row').first().clone();
        
        // Update row number and name attributes
        newRow.find('td:first').text(rowCount + 1);
        newRow.find('input, select').each(function() {
            const name = $(this).attr('name');
            if (name) {
                $(this).attr('name', name.replace('[0]', `[${rowCount}]`));
            }
            $(this).val(''); // Clear values
        });
        
        newRow.find('.vendor1-total, .vendor2-total, .vendor3-total').text('0');
        $('#itemsContainer').append(newRow);
        
        calculateTotals();
    });
    
    // Remove item row
    $(document).on('click', '.remove-item', function() {
        if ($('.item-row').length > 1) {
            $(this).closest('tr').remove();
            calculateTotals();
        }
    });
    
    // Calculate totals when prices or quantities change
    $(document).on('input', '.quantity, .price', function() {
        calculateTotals();
    });
    
    // Calculate totals when discount changes
    $('input[name$="_discount"]').on('input', function() {
        calculateTotals();
    });
    
    function calculateTotals() {
        let vendor1Total = 0;
        let vendor2Total = 0;
        let vendor3Total = 0;
        
        $('.item-row').each(function() {
            const quantity = parseFloat($(this).find('.quantity').val()) || 0;
            
            // Calculate for each vendor
            const vendor1Price = parseFloat($(this).find('.vendor1-price').val()) || 0;
            const vendor2Price = parseFloat($(this).find('.vendor2-price').val()) || 0;
            const vendor3Price = parseFloat($(this).find('.vendor3-price').val()) || 0;
            
            const vendor1RowTotal = quantity * vendor1Price;
            const vendor2RowTotal = quantity * vendor2Price;
            const vendor3RowTotal = quantity * vendor3Price;
            
            $(this).find('.vendor1-total').text(vendor1RowTotal.toLocaleString());
            $(this).find('.vendor2-total').text(vendor2RowTotal.toLocaleString());
            $(this).find('.vendor3-total').text(vendor3RowTotal.toLocaleString());
            
            vendor1Total += vendor1RowTotal;
            vendor2Total += vendor2RowTotal;
            vendor3Total += vendor3RowTotal;
        });
        
        // Update grand totals
        $('#vendor1-grand-total').text(vendor1Total.toLocaleString());
        $('#vendor2-grand-total').text(vendor2Total.toLocaleString());
        $('#vendor3-grand-total').text(vendor3Total.toLocaleString());
        
        // Calculate totals after discount
        const vendor1Discount = parseFloat($('input[name="vendor1_discount"]').val()) || 0;
        const vendor2Discount = parseFloat($('input[name="vendor2_discount"]').val()) || 0;
        const vendor3Discount = parseFloat($('input[name="vendor3_discount"]').val()) || 0;
        
        const vendor1Final = vendor1Total * (1 - vendor1Discount/100);
        const vendor2Final = vendor2Total * (1 - vendor2Discount/100);
        const vendor3Final = vendor3Total * (1 - vendor3Discount/100);
        
        $('#vendor1-final-total').text(vendor1Final.toLocaleString());
        $('#vendor2-final-total').text(vendor2Final.toLocaleString());
        $('#vendor3-final-total').text(vendor3Final.toLocaleString());
    }
});
</script>
@endpush