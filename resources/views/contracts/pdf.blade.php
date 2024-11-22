<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TEST PRINT</title>
</head>
<body>
    <h1>Periode {{ date('Y-m-d', strtotime($data['start_date'])) }} - {{ date('Y-m-d', strtotime($data['end_date'])) }}</h1>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Code</th>
                <th>Name</th>
                <th>Nama Perusahaan</th>
                <th>Nama Pekerjaan</th>
                <th>Nama Kontrak</th>
                <th>Jenis Pekerjaan</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['contracts'] as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->nama_perusahaan }}</td>
                    <td>{{ $item->nama_pekerjaan }}</td>
                    <td>{{ $item->nama_kontrak }}</td>
                    <td>{{ $item->jenis_pekerjaan }}</td>
                    <td>{{ $item->nominal_kontrak }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>