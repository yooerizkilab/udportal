<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Asuransi Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .pdf-container {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 30px;
            max-width: 800px;
            margin: 20px auto;
        }
        .section-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid #007bff;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .section-header h3 {
            color: #007bff;
            margin: 0;
            font-weight: 600;
        }
        .detail-row {
            margin-bottom: 15px;
        }
        .label {
            font-weight: 600;
            color: #495057;
        }
        .status-badge {
            font-size: 0.9em;
            padding: 5px 10px;
        }
        .status-expired {
            background-color: #dc3545;
            color: white;
        }
        .status-active {
            background-color: #28a745;
            color: white;
        }
        .vehicle-info {
            background-color: #f1f3f5;
            border-radius: 6px;
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="pdf-container">
            <div class="text-center mb-4">
                <h1 class="display-6">Detail Asuransi Kendaraan</h1>
                <hr>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="section-header">
                        <h3>Informasi Asuransi</h3>
                    </div>
                    <div class="row detail-row">
                        <div class="col-md-6">
                            <span class="label">Kode Asuransi:</span>
                            {{ $insurances->code }}
                        </div>
                        <div class="col-md-6">
                            <span class="label">Nomor Polis:</span>
                            {{ $insurances->policy_number }}
                        </div>
                    </div>
                    <div class="row detail-row">
                        <div class="col-md-6">
                            <span class="label">Penyedia Asuransi:</span>
                            {{ $insurances->insurances_provider }}
                        </div>
                        <div class="col-md-6">
                            <span class="label">Status:</span>
                            <span class="badge status-badge {{ $insurances->status == 'Expired' ? 'status-expired' : 'status-active' }}">
                                {{ $insurances->status }}
                            </span>
                        </div>
                    </div>
                    <div class="row detail-row">
                        <div class="col-md-6">
                            <span class="label">Mulai Pertanggungan:</span>
                            {{ \Carbon\Carbon::parse($insurances->coverage_start)->format('d F Y') }}
                        </div>
                        <div class="col-md-6">
                            <span class="label">Akhir Pertanggungan:</span>
                            {{ \Carbon\Carbon::parse($insurances->coverage_end)->format('d F Y') }}
                        </div>
                    </div>
                    <div class="row detail-row">
                        <div class="col-12">
                            <span class="label">Premi:</span>
                            Rp {{ number_format($insurances->premium, 2, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="section-header">
                        <h3>Informasi Kendaraan</h3>
                    </div>
                    <div class="vehicle-info">
                        <div class="row detail-row">
                            <div class="col-md-6">
                                <span class="label">Kode Kendaraan:</span>
                                {{ $insurances->vehicle->code }}
                            </div>
                            <div class="col-md-6">
                                <span class="label">Plat Nomor:</span>
                                {{ $insurances->vehicle->license_plate }}
                            </div>
                        </div>
                        <div class="row detail-row">
                            <div class="col-md-6">
                                <span class="label">Merek:</span>
                                {{ $insurances->vehicle->brand }}
                            </div>
                            <div class="col-md-6">
                                <span class="label">Model:</span>
                                {{ $insurances->vehicle->model }}
                            </div>
                        </div>
                        <div class="row detail-row">
                            <div class="col-md-6">
                                <span class="label">Tahun:</span>
                                {{ $insurances->vehicle->year }}
                            </div>
                            <div class="col-md-6">
                                <span class="label">Warna:</span>
                                {{ $insurances->vehicle->color }}
                            </div>
                        </div>
                        <div class="row detail-row">
                            <div class="col-md-6">
                                <span class="label">Transmisi:</span>
                                {{ $insurances->vehicle->transmission }}
                            </div>
                            <div class="col-md-6">
                                <span class="label">Bahan Bakar:</span>
                                {{ $insurances->vehicle->fuel }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="section-header">
                        <h3>Catatan</h3>
                    </div>
                    <div class="p-3 bg-light rounded">
                        {{ $insurances->notes ?? 'Tidak ada catatan' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>