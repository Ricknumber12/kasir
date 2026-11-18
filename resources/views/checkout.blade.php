<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Kopi Kita</title>
    <!-- Script Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        #pay-button { padding: 10px 20px; font-size: 16px; background: #007bff; color: white; border: none; cursor: pointer; border-radius: 5px; }
        #pay-button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h2>Total Belanja: Rp 45.000</h2>
    <button id="pay-button">Bayar Sekarang</button>

    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            // Panggil route checkout di backend untuk mendapatkan Snap Token
            fetch('/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Munculkan popup Snap Midtrans menggunakan token dari backend
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        alert("Pembayaran sukses! Struk sedang dicetak...");
                        console.log(result);
                    },
                    onPending: function(result) {
                        alert("Menunggu pembayaran...");
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal!");
                    }
                });
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Terjadi kesalahan saat memproses permintaan.");
            });
        });
    </script>
</body>
</html>