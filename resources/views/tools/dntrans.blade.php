<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DN Transport</title>
  </head>
  <body>
    <h1 class="text-center">Scan QR Code</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <div id="reader" style="display: none;"></div>
                        <form id="dnForm">
                            <div class="form-group">
                                <label for="codeEmploye">Code Pegawai</label>
                                <input type="text" class="form-control" id="codeEmploye" name="codeEmploye" required>
                            </div>
                            <div class="form-group">
                                <label for="customer">From</label>
                                <input type="text" class="form-control" id="from" name="from" required>
                            </div>
                            <div class="text-center"><i class="fas fa-arrow-down">-</i></div>
                            <div class="form-group">
                                <label for="to">To</label>
                                <input type="text" class="form-control" id="to" name="to" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="qty" name="qty" required>
                            </div>
                            <div class="form-group">
                                <label for="note">Note</label>
                                <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-success" id="startScan">Scan QR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.4/html5-qrcode.min.js"></script>
    <script>
        document.getElementById('startScan').addEventListener('click', function () {
            // Tangkap lokasi sebelum memulai scan QR
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
    
                    reverseGeocode(latitude, longitude).then((address) => {
                        startQrCodeScanner(address);
                    });
                }, (error) => {
                    console.error("Geolocation error:", error);
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });
    
        async function reverseGeocode(lat, lon) {
            const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`;
            try {
                const response = await fetch(url);
                const data = await response.json();
                return data.display_name || `${lat}, ${lon}`;
            } catch (error) {
                console.error("Error during reverse geocoding:", error);
                return `${lat}, ${lon}`;
            }
        }
    
        function startQrCodeScanner(address) {
            const html5QrCode = new Html5Qrcode("reader");
            document.getElementById('reader').style.display = 'block';
    
            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                },
                (decodedText) => {
                    html5QrCode.stop().then(() => {
                        document.getElementById('reader').style.display = 'none';
                        saveDataToDatabase(decodedText, address);
                        // console.log(decodedText)
                        // console.log(address);
                        
                    }).catch((err) => {
                        console.error("Error stopping QR scanner:", err);
                    });
                },
                (errorMessage) => {
                    console.error("Error scanning QR code:", errorMessage);
                }
            ).catch((err) => {
                console.error("Unable to start QR scanner:", err);
            });
        }
    
        function saveDataToDatabase(qrCodeMessage, address) {
            // Ambil data dari form
            const formData = $('#dnForm').serializeArray();
            const data = {};

            // Masukkan data form ke objek data
            formData.forEach(item => {
                data[item.name] = item.value;
            });

            // Tambahkan data QR code dan lokasi ke objek data
            data.qrCode = qrCodeMessage;
            data.location = address;

            console.log(data);
            // Kirim data ke server menggunakan AJAX
            $.ajax({
                url: "{{ route('dntrans.store') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function (response) {
                    alert('Data berhasil disimpan.');
                    location.reload(); // Refresh halaman setelah berhasil
                },
                error: function (xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
                }
            });
        }
    </script>
    </body>
</html>