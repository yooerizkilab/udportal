<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DN Transport</title>
</head>
<body>
    {{-- <h1 class="text-center">Scan Delivery Note</h1> --}}
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="card-title">Scan Delivery Note</h4>
                    </div>
                    <div class="card-body">
                        <form id="dnForm">
                            <div class="col-md-12">
                                <div id="reader" style="display:none;" class="text-center mb-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="codeEmploye">Code Pegawai</label>
                                        <input type="text" class="form-control" id="codeEmploye" name="codeEmploye" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="type">Select Type</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="">-- Select Type Delivery --</option>
                                            <option value="Delivery Note">Delivery Note</option>
                                            <option value="Transfer">Transfer</option>
                                            <option value="Return">Return</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="driver_name">Driver Name</label>
                                        <input type="text" class="form-control" id="driver_name" name="driver_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="source_project_id">Source Project</label>
                                        <select name="source_project_id" id="source_project_id" class="form-control">
                                            <option value="" disabled selected>--Select Source Project--</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->name }} - {{ $project->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="driver_phone">Driver Phone</label>
                                        <input type="text" class="form-control" id="driver_phone" name="driver_phone" required>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <span>
                                            <i class="fas fa-arrow-right fa-3x mt-4"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="delivery_date">Delivery Date</label>
                                        <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="destination_project_id">Destination Project</label>
                                        <select class="form-control" id="destination_project_id" name="destination_project_id" required>
                                            <option value="">-- Select Destination Project --</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->name }} - {{ $project->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="notes">Note</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
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
                            <a href="{{ url('/') }}" class="btn btn-info mr-2"><i class="fas fa-reply"></i> Kembali</a>
                            <button type="button" class="btn btn-success mr-2" id="startScan"><i class="fas fa-qrcode"></i> Scan QR</button>
                            <button type="button" class="btn btn-primary" id="saveData"><i class="fas fa-print"></i> Save and Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.4/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Geolocation is not supported by this browser.',
                    showConfirmButton: true
                })
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
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Tidak ada data yang disimpan. Silakan scan QR terlebih dahulu.'
                })
                return;
            }

            // Cek apakah field sudah diisi
            // if (!document.getElementById('codeEmploye').value || !document.getElementById('from').value || !document.getElementById('to').value) {
            //     alert("Semua field harus diisi.");
            //     return;
            // }

            const formData = {
                codeEmploye: document.getElementById('codeEmploye').value,
                type_delivery: document.getElementById('type').value,
                driver_name: document.getElementById('driver_name').value,
                driver_phone: document.getElementById('driver_phone').value,
                delivery_date: document.getElementById('delivery_date').value,
                source_project_id: document.getElementById('source_project_id').value,
                destination_project_id: document.getElementById('destination_project_id').value,
                notes: document.getElementById('notes').value,
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        showConfirmButton: true
                    }).then(() => {

                        // print PDF
                        window.open("dn-transport/pdf", "_blank");

                        // reset scannedItems
                        scannedItems = [];
                        updateTable();
                        
                        // reset form
                    })
                },
                error: function (xhr, status, error) {
                    console.error("Error saving data:", xhr, status, error);
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Saving Data',
                            text: xhr.responseJSON.message,
                            showConfirmButton: true
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error,
                            showConfirmButton: true
                        })
                    }
                }
            });
        });
    </script>
</body>
</html>
