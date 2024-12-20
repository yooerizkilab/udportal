<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-details {
            font-size: 12px;
            margin-bottom: 5px;
        }
        .document-title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
            text-decoration: underline;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-row {
            margin-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f0f0f0;
        }
        .footer {
            margin-top: 50px;
        }
        .signature-section {
            float: right;
            width: 200px;
            text-align: center;
        }
        .signature-line {
            margin-top: 80px;
            border-top: 1px solid #000;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="header">
        {{-- <div class="company-name">{{ $company_name }}</div>
        <div class="company-details">{{ $company_address }}</div>
        <div class="company-details">Telp: {{ $company_phone }}</div> --}}
    </div>

    <div class="document-title">SURAT JALAN</div>

    <div class="info-section">
        {{-- <div class="info-row">No. Surat Jalan: {{ $no_surat }}</div>
        <div class="info-row">Tanggal: {{ $tanggal }}</div> --}}
    </div>

    <div class="info-section">
        <div class="info-row">Kepada Yth:</div>
        {{-- <div class="info-row">{{ $customer_name }}</div>
        <div class="info-row">{{ $customer_address }}</div>
        <div class="info-row">Telp: {{ $customer_phone }}</div> --}}
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->satuan }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            @endforeach --}}
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-section">
            {{-- <div>{{ $kota }}, {{ $tanggal }}</div> --}}
            <div>Hormat Kami,</div>
            <div class="signature-line"></div>
            {{-- <div>{{ $nama_pengirim }}</div> --}}
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>