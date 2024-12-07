<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DN Transport</title>
</head>
<body>
    <h1 class="text-center">Scan QR Code</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <form id="dnForm">
                            <div id="reader" style="display:none;" class="text-center mb-3"></div>
                            <div class="form-group">
                                <label for="codeEmploye">Code Pegawai</label>
                                <input type="text" class="form-control" id="codeEmploye" name="codeEmploye" required>
                            </div>
                            <div class="form-group">
                                <label for="from">From</label>
                                <input type="text" class="form-control" id="from" name="from" required>
                            </div>
                            <div class="form-group">
                                <label for="to">To</label>
                                <input type="text" class="form-control" id="to" name="to" required>
                            </div>
                            <div class="form-group">
                                <label for="activity">Activity</label>
                                <input type="text" class="form-control" id="activity" name="activity" required>
                            </div>
                            <div class="form-group">
                                <label for="note">Note</label>
                                <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="itemTable">
                                    <thead>
                                        <tr>
                                            <th>QR Code</th>
                                            <th>Lokasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-success mr-2" id="startScan">Scan QR</button>
                            <button type="button" class="btn btn-primary" id="saveData">Save Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.4/html5-qrcode.min.js"></script>
    <script>
        let scannedItems = [];

        document.getElementById('startScan').addEventListener('click', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async (position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    const location = await reverseGeocode(latitude, longitude);

                    startQrCodeScanner(location);
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

        function startQrCodeScanner(location) {
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

                        scannedItems.push({ qr: decodedText, location });
                        updateTable();
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

        function updateTable() {
            const tbody = document.querySelector("#itemTable tbody");
            tbody.innerHTML = "";

            scannedItems.forEach((item, index) => {
                const row = `<tr>
                                <td>${item.qr}</td>
                                <td>${item.location}</td>
                                <td><button class="btn btn-danger btn-sm btn-circle" onclick="removeItem(${index})">Hapus</button></td>
                             </tr>`;
                tbody.insertAdjacentHTML("beforeend", row);
            });
        }

        function removeItem(index) {
            scannedItems.splice(index, 1);
            updateTable();
        }

        document.getElementById('saveData').addEventListener('click', function () { 
            // Cek apakah ada data yang belum disimpan
            if (scannedItems.length === 0) {
                alert("Tidak ada data yang harus disimpan.");
                return;
            }

            // Cek apakah field sudah diisi
            if (!document.getElementById('codeEmploye').value || !document.getElementById('from').value || !document.getElementById('to').value) {
                alert("Semua field harus diisi.");
                return;
            }

            const formData = {
                codeEmploye: document.getElementById('codeEmploye').value,
                from: document.getElementById('from').value,
                to: document.getElementById('to').value,
                activity: document.getElementById('activity').value,
                note: document.getElementById('note').value,
                items: scannedItems
            };
            

            $.ajax({
                url: "{{ route('dntrans.store') }}", // Pastikan dalam tanda kutip
                method: "POST",
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token
                },
                data: formData,
                success: function (response) {
                    alert("Data berhasil disimpan!");
                    scannedItems = [];
                    updateTable();
                    // reset form
                    document.getElementById('codeEmploye').value = '';
                    document.getElementById('from').value = '';
                    document.getElementById('to').value = '';
                    document.getElementById('activity').value = '';
                    document.getElementById('note').value = '';

                },
                error: function (xhr, status, error) {
                    console.error("Error saving data:", xhr, status, error);
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        alert("Gagal menyimpan data: " + xhr.responseJSON.message);
                    } else {
                        alert("Gagal menyimpan data. Silakan coba lagi.");
                    }
                }
            });
        });
    </script>
</body>
</html>
