@extends('layouts.admin', [
    'title' => 'Bids Inventory Management'
]);

@push('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('main-content')
<div class="container mx-auto px-4 py-5">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Create Cost Bid</h1>
        <a href="{{ route('bids-inventory.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Back</a>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <strong class="font-bold">Error!</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('bids-inventory.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        
        {{-- Basic Information --}}
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="document_date">
                        Document Date *
                    </label>
                    <input type="date" 
                           name="document_date" 
                           id="document_date"
                           value="{{ old('document_date', date('Y-m-d')) }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="for_company">
                        For Company *
                    </label>
                    <input type="text"
                           name="for_company"
                           id="for_company"
                           value="{{ old('for_company') }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           required>
                </div>
            </div>
        </div>

        {{-- Vendor Items Section --}}
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Vendor Items</h2>
            
            <div id="vendor-container">
                @foreach($vendors as $index => $vendor)
                <div class="vendor-section mb-6 p-4 border rounded">
                    <h3 class="font-bold mb-3">{{ $vendor->name }}</h3>
                    <input type="hidden" name="vendors[{{ $index }}][id]" value="{{ $vendor->id }}">

                    <div class="items-container">
                        <table class="table-auto border-collapse border border-gray-200 w-full">
                            <tbody>
                                <!-- Header di sisi kiri -->
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Item</th>
                                    <td class="vendor-items border border-gray-300"></td>
                                </tr>
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Price/Unit</th>
                                    <td class="vendor-prices border border-gray-300"></td>
                                </tr>
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Subtotal</th>
                                    <td class="vendor-subtotals border border-gray-300"></td>
                                </tr>
                            </tbody>
                        </table>

                        <button type="button" 
                                onclick="addItem({{ $index }}, {{ $vendor->id }})"
                                class="btn btn-primary mt-4">
                            Add Item
                        </button>
                    </div>
                </div>
                @endforeach


            </div>
        </div>

        {{-- Analysis Section --}}
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Analysis</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="selected_vendor_id">
                        Selected Vendor *
                    </label>
                    <select name="selected_vendor_id"
                            id="selected_vendor_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ old('selected_vendor_id') == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="discount_percentage">
                        Discount (%)
                    </label>
                    <input type="number"
                           name="discount_percentage"
                           id="discount_percentage"
                           value="{{ old('discount_percentage', 0) }}"
                           step="0.01"
                           min="0"
                           max="100"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="terms_of_payment">
                        Terms of Payment
                    </label>
                    <input type="text"
                           name="terms_of_payment"
                           id="terms_of_payment"
                           value="{{ old('terms_of_payment') }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="lead_time">
                        Lead Time
                    </label>
                    <input type="text"
                           name="lead_time"
                           id="lead_time"
                           value="{{ old('lead_time') }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="notes">
                    Notes
                </label>
                <textarea name="notes"
                          id="notes"
                          rows="3"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('notes') }}</textarea>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-end">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Create Cost Bid
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    function addItem(index, vendorId) {
        // Temukan tabel berdasarkan vendor index
        const itemsCell = document.querySelectorAll(`.vendor-section:nth-child(${index + 1}) .vendor-items`)[0];
        const pricesCell = document.querySelectorAll(`.vendor-section:nth-child(${index + 1}) .vendor-prices`)[0];
        const subtotalsCell = document.querySelectorAll(`.vendor-section:nth-child(${index + 1}) .vendor-subtotals`)[0];

        // Buat elemen input untuk setiap kolom

        // untuk item pilih dari database dengan select option
        const itemInput = document.createElement('input');
        itemInput.type = 'text';
        itemInput.name = `vendors[${index}][items][]`;
        itemInput.className = 'border border-gray-300 p-1 w-full';

        const priceInput = document.createElement('input');
        priceInput.type = 'number';
        priceInput.name = `vendors[${index}][prices][]`;
        priceInput.className = 'border border-gray-300 p-1 w-full';

        const subtotalInput = document.createElement('input');
        subtotalInput.type = 'number';
        subtotalInput.name = `vendors[${index}][subtotals][]`;
        subtotalInput.className = 'border border-gray-300 p-1 w-full';

        // Tambahkan input ke kolom masing-masing
        itemsCell.appendChild(itemInput);
        quantitiesCell.appendChild(quantityInput);
        uomsCell.appendChild(uomInput);
        pricesCell.appendChild(priceInput);
        subtotalsCell.appendChild(subtotalInput);
    }


    function updateUOM(selectElement) {
        const itemRow = selectElement.closest('.items-row');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const uomDisplay = itemRow.querySelector('.uom-display');
        uomDisplay.value = selectedOption.dataset.uom;
    }

    function calculateSubtotal(inputElement) {
        const itemRow = inputElement.closest('.items-row');
        const quantity = parseFloat(itemRow.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(itemRow.querySelector('.price-input').value) || 0;
        const subtotalDisplay = itemRow.querySelector('.subtotal-display');
        const subtotal = quantity * price;
        subtotalDisplay.value = subtotal.toFixed(2);
    }
</script>
@endpush