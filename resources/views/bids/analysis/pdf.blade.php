<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cost Bid Comparison</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printable-section, #printable-section * {
                visibility: visible;
            }
            #printable-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .table {
                font-size: 10px;
            }
        }
        .table-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .vendor-header {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-4" id="printable-section">
        <!-- Document Header -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h3 class="mb-3">Cost Bid Analysis</h3>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Code</td>
                                <td>: {{ $costbid->code }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Document Date</td>
                                <td>: {{ $costbid->document_date }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Bid Date</td>
                                <td>: {{ $costbid->bid_date }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Project Name</td>
                                <td>: {{ $costbid->project_name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="table-header">
                                <th rowspan="2" class="align-middle text-center">No</th>
                                <th rowspan="2" class="align-middle text-center">Description</th>
                                <th rowspan="2" class="align-middle text-center">QTY</th>
                                <th rowspan="2" class="align-middle text-center">UOM</th>
                                @foreach ($costbid->vendors as $vendor)
                                    <th colspan="2" class="text-center vendor-header">{{ $vendor->name }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($costbid->vendors as $vendor)
                                    <th class="text-center vendor-header">Price/Unit</th>
                                    <th class="text-center vendor-header">Total</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($costbid->items as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-center">{{ $item->uom }}</td>
                                    @foreach ($costbid->vendors as $vendor)
                                        @php
                                            $analysis = $item->costBidsAnalysis->firstWhere('cost_bids_vendor_id', $vendor->id);
                                            $price = $analysis ? $analysis->price : '-';
                                            $total = $analysis ? $analysis->price * $item->quantity : '-';
                                        @endphp
                                        <td class="text-end">Rp {{ number_format($price, 2) }}</td>
                                        <td class="text-end">Rp {{ number_format($total, 2) }}</td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 4 + (count($costbid->vendors) * 2) }}" class="text-center">No Items Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            @php
                                $footerRows = [
                                    ['label' => 'TOTAL', 'key' => 'grand_total'],
                                    ['label' => 'DISCOUNT (%)', 'key' => 'discount'],
                                    ['label' => 'TOTAL After Discount', 'key' => 'final_total'],
                                    ['label' => 'Terms of Payment (Days)', 'key' => 'terms_of_payment'],
                                    ['label' => 'Lead Time (Days)', 'key' => 'lead_time']
                                ];
                            @endphp
                            @foreach ($footerRows as $row)
                                <tr class="table-light fw-bold">
                                    <td colspan="4" class="text-end">{{ $row['label'] }}</td>
                                    @foreach ($costbid->vendors as $vendor)
                                        <td colspan="2" class="text-end">
                                            @if ($row['key'] == 'discount')
                                                {{ $vendor->{$row['key']} }}%
                                            @elseif (in_array($row['key'], ['grand_total', 'final_total']))
                                                Rp {{ number_format($vendor->{$row['key']}, 2) }}
                                            @else
                                                {{ $vendor->{$row['key']} }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Font Awesome (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</body>
</html>