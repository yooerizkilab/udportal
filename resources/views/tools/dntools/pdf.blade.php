<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delivery Order</title>
  <style>
    body {
    font-family: Arial, sans-serif;
    margin: 20px;
    }

    .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #000;
    }

    header {
    text-align: center;
    margin-bottom: 20px;
    }

    header h1 {
    margin: 0;
    font-size: 24px;
    }

    header p {
    margin: 5px 0;
    font-size: 12px;
    }

    h2 {
    text-align: center;
    text-decoration: underline;
    }

    .order-info, .recipient-info {
    margin-bottom: 15px;
    }

    .order-info p, .recipient-info p {
    margin: 5px 0;
    }

    table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
    }

    table th, table td {
    border: 1px solid #000;
    text-align: left;
    padding: 8px;
    }

    table th {
    background-color: #f2f2f2;
    }

    .notes {
    margin-bottom: 20px;
    }

    .notes ol {
    margin: 0;
    padding-left: 20px;
    }

    .signature {
    display: flex;
    justify-content: space-between;
    }

    .signature .sender, .signature .receiver {
    width: 45%;
    text-align: center;
    }

    .signature p {
    margin: 5px 0;
    }

  </style>
</head>
<body>
  <div class="container">
    <header>
      <h1>PT. Usahaku.com</h1>
      <p>Jl. Kapasan No. 100, Surabaya, | Telp. (031) 3712345 | Email: yudi@usahaku.com</p>
    </header>
    <h2>DELIVERY ORDER</h2>
    <div class="order-info">
      <p>No: <span>DO-2024-001</span></p>
      <p>Tanggal: <span>19 Juni 2024</span></p>
    </div>
    <div class="recipient-info">
      <p>Kepada: <strong>Bapak Latief Nugroho</strong></p>
      <p>PT. Nusantara</p>
      <p>Jl. Kapasan No. 1, Surabaya</p>
      <p>Telp. (031) 3721222</p>
    </div>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Barang</th>
          <th>Deskripsi</th>
          <th>Jumlah</th>
          <th>Satuan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Laptop ABC</td>
          <td>Processor i5, RAM 8GB</td>
          <td>10</td>
          <td>Unit</td>
        </tr>
        <tr>
          <td>2</td>
          <td>Printer XYZ</td>
          <td>Laser, Warna</td>
          <td>5</td>
          <td>Unit</td>
        </tr>
        <tr>
          <td>3</td>
          <td>Mouse Wireless</td>
          <td>Optical, USB Receiver</td>
          <td>20</td>
          <td>Unit</td>
        </tr>
        <tr>
          <td>4</td>
          <td>Keyboard Wireless</td>
          <td>Full-size, USB Receiver</td>
          <td>20</td>
          <td>Unit</td>
        </tr>
      </tbody>
    </table>
    <div class="notes">
      <p><strong>Catatan:</strong></p>
      <ol>
        <li>Harap periksa barang yang diterima sesuai dengan detail yang tercantum di atas.</li>
        <li>Segera laporkan kepada kami jika terdapat ketidaksesuaian atau kerusakan barang dalam waktu 2x24 jam setelah barang diterima.</li>
        <li>Kontak Penerima: 08123123123 (Bapak Latief Nugroho)</li>
      </ol>
    </div>
    <div class="signature">
      <div class="sender">
        <p>Tanda Tangan:</p>
        <p>Pengirim,</p>
        <br><br>
        <p>Ali Jaya</p>
        <p>PT. Usahaku.com</p>
      </div>
      <div class="receiver">
        <p>Tanda Tangan:</p>
        <p>Penerima,</p>
        <br><br>
        <p>(PT. Nusantara)</p>
      </div>
    </div>
  </div>
</body>
</html>
