<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Maintenance Kendaraan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .company-info {
            margin-bottom: 20px;
        }
        .report-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 50px;
        }
        .signature {
            float: right;
            width: 200px;
            text-align: center;
        }
        .vehicle-info {
            margin-bottom: 20px;
        }
        .maintenance-info {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN MAINTENANCE KENDARAAN</h2>
    </div>

    <div class="company-info">
        <h4>{{ $company_name ?? 'Nama Perusahaan' }}</h4>
        <p>{{ $company_address ?? 'Alamat Perusahaan' }}</p>
        <p>Telp: {{ $company_phone ?? 'Nomor Telepon' }}</p>
    </div>

    <div class="report-info">
        <table>
            <tr>
                <td width="200">Nomor Maintenance</td>
                <td>: {{ $maintenance->code }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ date('d/m/Y', strtotime($maintenance->maintenance_date)) }}</td>
            </tr>
        </table>
    </div>

    <div class="vehicle-info">
        <h4>Informasi Kendaraan</h4>
        <table>
            <tr>
                <td width="200">Kode Kendaraan</td>
                <td>: {{ $maintenance->vehicle->code }}</td>
            </tr>
            <tr>
                <td>Merk/Model</td>
                <td>: {{ $maintenance->vehicle->brand }} {{ $maintenance->vehicle->model }}</td>
            </tr>
            <tr>
                <td>No. Polisi</td>
                <td>: {{ $maintenance->vehicle->license_plate }}</td>
            </tr>
            <tr>
                <td>Tahun</td>
                <td>: {{ $maintenance->vehicle->year }}</td>
            </tr>
            <tr>
                <td>Transmisi</td>
                <td>: {{ $maintenance->vehicle->transmission }}</td>
            </tr>
            <tr>
                <td>Bahan Bakar</td>
                <td>: {{ $maintenance->vehicle->fuel }}</td>
            </tr>
        </table>
    </div>

    <div class="maintenance-info">
        <h4>Detail Maintenance</h4>
        <table>
            <tr>
                <td width="200">Kilometer</td>
                <td>: {{ number_format($maintenance->mileage, 0, ',', '.') }} KM</td>
            </tr>
            <tr>
                <td>Jenis Maintenance</td>
                <td>: {{ $maintenance->description }}</td>
            </tr>
            <tr>
                <td>Biaya</td>
                <td>: Rp {{ number_format($maintenance->cost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: {{ $maintenance->status }}</td>
            </tr>
            <tr>
                <td>Jadwal Maintenance Berikutnya</td>
                <td>: {{ date('d/m/Y', strtotime($maintenance->next_maintenance)) }}</td>
            </tr>
            @if($maintenance->notes)
            <tr>
                <td>Catatan</td>
                <td>: {{ $maintenance->notes }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="footer">
        <div class="signature">
            <p>{{ $city ?? 'Kota' }}, {{ date('d/m/Y') }}</p>
            <br><br><br>
            <p>({{ $signature_name ?? 'Nama Penanda Tangan' }})</p>
            <p>{{ $position ?? 'Jabatan' }}</p>
        </div>
    </div>
</body>
</html>