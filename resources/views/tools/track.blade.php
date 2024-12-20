<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code</title>
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.4/html5-qrcode.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #reader {
            width: 100%;
            max-width: 400px;
            margin: auto;
            display: none; /* Scanner hidden until button is clicked */
        }

        #tool-container {
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="text-center mb-4">Scan QR Code</h1>
        <div class="text-center">
            <button id="startButton" class="btn btn-primary">Start Scanning</button>
        </div>
        <div id="reader" class="mt-4"></div>
        <div class="text-center mt-4">
            <p>
                <strong>Result:</strong>
                <span id="result" class="text-secondary">No QR Code scanned</span>
            </p>
            <a href="{{ url('/') }}" class="btn btn-link">Back</a>
            <a href="{{ route('track.tools') }}" class="btn btn-link">Reload</a>
        </div>
        <div id="tool-container" class="bg-white p-4 rounded shadow-sm"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const html5QrCode = new Html5Qrcode("reader");

        document.getElementById("startButton").addEventListener("click", function () {
            const readerDiv = document.getElementById("reader");
            readerDiv.style.display = "block";
            this.style.display = "none";

            html5QrCode.start({ facingMode: "environment" }, {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            }, (qrCodeMessage) => {
                document.getElementById("result").innerHTML = qrCodeMessage;

                html5QrCode.stop().then(() => {
                    readerDiv.style.display = "none";

                    // Kirim data QR Code ke backend
                    $.ajax({
                        url: "{{ route('tracking.tools') }}",
                        method: "POST",
                        data: {
                            qrCodeData: qrCodeMessage,
                            _token: "{{ csrf_token() }}" // Tambahkan CSRF token untuk keamanan
                        },
                        success: function (response) {
                            if (response.success) {
                                const data = response.data;

                                // Hapus konten lama jika ada
                                const existingContainer = document.getElementById('tool-container');
                                if (existingContainer) {
                                    existingContainer.remove();
                                }

                                // Buat elemen container card
                                const cardContainer = document.createElement('div');
                                cardContainer.id = 'tool-container';
                                cardContainer.classList.add('card', 'mt-2');

                                // Tambahkan header card
                                const cardHeader = `
                                    <div class="card-header bg-primary text-white">
                                        <h5>Item & Transaction Details</h5>
                                    </div>
                                `;
                                cardContainer.innerHTML += cardHeader;

                                // Tambahkan body card
                                let cardBody = `
                                    <div class="card-body">
                                        <h5 class="text-secondary">Item Details</h5>
                                        <p><strong>Tool Name:</strong> ${data[0]?.tools?.name || 'N/A'}</p>
                                        <p><strong>Code:</strong> ${data[0]?.tools?.code || 'N/A'}</p>
                                        <p><strong>Brand:</strong> ${data[0]?.tools?.brand || 'N/A'}</p>
                                        <p><strong>Condition:</strong> ${data[0]?.tools?.condition || 'N/A'}</p>
                                        <p><strong>Model:</strong> ${data[0]?.tools?.model || 'N/A'}</p>
                                        <p><strong>Year:</strong> ${data[0]?.tools?.year || 'N/A'}</p>
                                        
                                        <hr>
                                        
                                        <h5 class="text-secondary">Transaction Details</h5>
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Activity</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>Location</th>
                                                    <th>Transaction Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                `;

                                // Tambahkan isi tabel aktivitas (berulang)
                                data.forEach(item => {
                                    cardBody += `
                                        <tr>
                                            <td>${item.type || 'N/A'}</td>
                                            <td>${item.source_project_id || 'N/A'}</td>
                                            <td>${item.destination_project_id || 'N/A'}</td>
                                            <td>${item.last_location || 'N/A'}</td>
                                            <td>${item.created_at || 'N/A'}</td>
                                        </tr>
                                    `;
                                });

                                cardBody += `
                                            </tbody>
                                        </table>
                                    </div>
                                `;

                                // Tambahkan body ke dalam card
                                cardContainer.innerHTML += cardBody;

                                // Tambahkan card ke dalam body
                                document.body.appendChild(cardContainer);
                            } else {
                                alert(response.message || "Failed to fetch data.");
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                            alert( xhr.responseJSON.message || "An error occurred. Please try again.");
                        }
                    });

                }).catch(err => {
                    console.error("Failed to stop scanner:", err);
                });
            }, (errorMessage) => {
                console.error(errorMessage);
            });
        });
    </script>
</body>
</html>
