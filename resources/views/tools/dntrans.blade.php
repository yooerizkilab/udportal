<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code</title>
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.4/html5-qrcode.min.js"></script>
    <style>
        #reader {
            width: 300px;
            margin: auto;
            display: none; /* Scanner hidden until button is clicked */
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Scan QR Code DN Transport</h1>
    <label for="">Code Pegawai</label>
    <input type="text" name="code" id="code">
    <label for="">From</label>
    <input type="text" name="from" id="from">
    <label for="">To</label>
    <input type="text" name="to" id="to">
    <Label>Quantity</Label>
    <input type="text" name="" id="">
    <Label>Activity</Label>
    <input type="text" name="" id="">
    <Label>Note</Label>
    <input type="text" name="" id="">
    <button id="startButton">Start Scanning</button>
    <div id="reader"></div>
    <p style="text-align: center;">
        <strong>Result:</strong>
        <span id="result">No QR Code scanned</span><br>
        <a href="{{ url('/') }}">Kembali</a>
    </p>
    


    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script>
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
                    console.log("Scanner stopped successfully.");
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

                                // Bersihkan konten lama jika perlu
                                const existingContainer = document.getElementById('tool-container');
                                if (existingContainer) {
                                    existingContainer.remove();
                                }

                                // Buat elemen container untuk menampung semua data
                                const container = document.createElement('div');
                                container.id = 'tool-container';
                                container.style.padding = '20px';
                                container.style.border = '1px solid #ccc';
                                container.style.marginTop = '20px';
                                container.style.backgroundColor = '#f9f9f9';

                                // Loop melalui data
                                data.forEach(item => {
                                    const tool = item.tools;

                                    // Validasi apakah tools ada di dalam data
                                    if (!tool) {
                                        console.warn('Tool data is missing for item:', item);
                                        return;
                                    }

                                    // Buat elemen HTML untuk item ini
                                    const toolHTML = `
                                        <div style="margin-bottom: 20px;">
                                            <p><strong>Activity:</strong> ${item.activity || 'N/A'}</p>
                                            <p><strong>From:</strong> ${item.from || 'N/A'}</p>
                                            <p><strong>To:</strong> ${item.to || 'N/A'}</p>
                                            <p><strong>Type:</strong> ${item.type || 'N/A'}</p>
                                            <p><strong>Transaction Date:</strong> ${item.transaction_date || 'N/A'}</p>
                                            <p><strong>Tool Name:</strong> ${tool.name || 'N/A'}</p>
                                            <p><strong>Code:</strong> ${tool.code || 'N/A'}</p>
                                            <p><strong>Brand:</strong> ${tool.brand || 'N/A'}</p>
                                            <p><strong>Condition:</strong> ${tool.condition || 'N/A'}</p>
                                            <p><strong>Model:</strong> ${tool.model || 'N/A'}</p>
                                            <p><strong>Year:</strong> ${tool.year || 'N/A'}</p>
                                            <hr>
                                        </div>
                                    `;

                                    // Tambahkan elemen ke dalam container
                                    container.innerHTML += toolHTML;
                                });

                                // Tambahkan container ke dalam body atau lokasi lain yang diinginkan
                                document.body.appendChild(container);
                            } else {
                                alert(response.message || "Failed to fetch data.");
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                            alert("An error occurred. Please try again.");
                        }
                    });


                }).catch(err => {
                    console.error("Failed to stop scanner:", err);
                });
            }, (errorMessage) => {
                console.error(errorMessage);
            });
        });


    </script> --}}
</body>
</html>
 