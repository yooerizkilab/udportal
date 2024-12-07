<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Maintenance Kendaraan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.5;
            color: #333;
            font-size: 9pt;
        }

        .maintenance-document {
            max-width: 210mm;
            margin: 0 auto;
            padding: 15mm;
            background-color: white;
        }

        .document-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .company-logo {
            width: 80px;
            height: auto;
        }

        .document-title {
            font-size: 14pt;
            font-weight: 700;
            color: #3498db;
        }

        .vehicle-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            background-color: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #e0e0e0;
            padding: 5px 0;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-item-label {
            font-weight: 600;
            color: #555;
        }

        .detail-item-value {
            text-align: right;
            color: #333;
        }

        .maintenance-section {
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 11pt;
            font-weight: 700;
            color: #3498db;
            border-bottom: 1px solid #3498db;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .maintenance-record {
            background-color: #f9f9f9;
            border-left: 3px solid #2ecc71;
            padding: 8px;
            margin-bottom: 8px;
        }

        .record-label {
            font-weight: 600;
            margin-bottom: 3px;
        }

        .record-details {
            color: #666;
        }

        .document-footer {
            margin-top: 15px;
            text-align: center;
            font-size: 8pt;
            color: #888;
            border-top: 1px solid #e0e0e0;
            padding-top: 10px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .maintenance-document {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-document">
        <header class="document-header">
            <img src="/api/placeholder/100/50" alt="Logo Perusahaan" class="company-logo">
            <div class="document-title">Laporan Maintenance Kendaraan</div>
        </header>

        <section class="vehicle-details">
            <div class="detail-item">
                <span class="detail-item-label">Nomor Polisi :</span>
                <span class="detail-item-value">{{ $vehicles->vehicle->license_plate }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-item-label">Merk Kendaraan :</span>
                <span class="detail-item-value">{{ $vehicles->vehicle->model }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-item-label">Tahun</span>
                <span class="detail-item-value">{{ $vehicles->vehicle->year }}</span>
            </div>
        </section>

        <section class="maintenance-section">
            <h2 class="section-title">Riwayat Service Terakhir</h2>
            <div class="maintenance-record">
                <div class="record-label">Tanggal Service</div>
                <div class="record-details">{{ $vehicles->maintenance_date }}</div>
            </div>
            <div class="maintenance-record">
                <div class="record-label">Kilometer</div>
                <div class="record-details">{{ $vehicles->kilometer }} km</div>
            </div>
        </section>

        <section class="maintenance-section">
            <h2 class="section-title">Riwayat Penggantian Komponen</h2>
            <div class="maintenance-record">
                {{ $vehicles->description }}
            </div>
        </section>

        <section class="maintenance-section">
            <h2 class="section-title">Catatan Maintenance</h2>
            <div class="maintenance-record">
                {{ $vehicles->notes }}
            </div>
        </section>

        <footer class="document-footer">
            <p>Dicetak: {{ date('Y-m-d') }} | Nomor Dokumen: {{ $vehicles->code }}</p>
        </footer>
    </div>
</body>
</html>