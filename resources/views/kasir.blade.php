<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Toko Retail Makmur</title>
    <!-- Script Midtrans Snap -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-size: 14px;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 15px 20px;
            background-color: white;
            border-bottom: 1px solid #dee2e6;
        }
        .store-info h4 {
            margin: 0;
            font-weight: bold;
        }
        .store-info p {
            margin: 0;
            color: #6c757d;
            font-size: 12px;
        }
        .transaction-info {
            text-align: right;
            font-size: 12px;
            color: #6c757d;
        }
        .transaction-info strong {
            color: #212529;
            font-size: 14px;
        }
        .card-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .table-cart th {
            font-weight: 600;
            color: #495057;
            font-size: 13px;
        }
        .empty-cart-msg {
            text-align: center;
            padding: 50px 0;
            color: #adb5bd;
            font-size: 13px;
        }
        .summary-label {
            font-size: 13px;
            color: #495057;
        }
        .summary-input {
            text-align: right;
            height: 30px;
            font-size: 13px;
        }
        .total-akhir-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .total-akhir-label {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .total-akhir-value {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .payment-box {
            background-color: #eef2f5;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .uang-dibayar-input {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #0d6efd;
            height: 45px;
        }
        .method-btn {
            font-size: 12px;
            padding: 5px 0;
        }
        .kembalian-box {
            background-color: #d1e7dd;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .kembalian-label {
            font-size: 12px;
            color: #0f5132;
            margin-bottom: 2px;
        }
        .kembalian-value {
            font-size: 18px;
            font-weight: bold;
            color: #0f5132;
            margin: 0;
        }
        .action-btn-group {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .btn-bayar {
            width: 100%;
            height: 50px;
            font-weight: bold;
            margin-top: 10px;
        }
        .footer-bar {
            background-color: #212529;
            color: white;
            padding: 8px 20px;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header-section">
        <div class="store-info">
            <h4>TOKO RETAIL MAKMUR</h4>
            <p>Jl. Contoh No. 123 • Jember • Telp. 0812-xxxx-xxxx</p>
        </div>
        <div class="transaction-info">
            No. Transaksi<br>
            <strong>TRX-20260911-001</strong><br>
            22/9/2026, 16:55:18
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid mt-3 mb-5 pb-4">
        <div class="row">
            
            <!-- Left Panel (Cart & Input) -->
            <div class="col-md-8">
                
                <!-- Tambah Barang Card -->
                <div class="card mb-3">
                    <div class="card-body pb-2">
                        <h6 class="card-title">Tambah Barang</h6>
                        
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Cari nama barang / kode / barcode...">
                            <button class="btn btn-primary px-4" type="button">Cari</button>
                        </div>
                        
                        <div class="row g-3 align-items-center mb-2">
                            <div class="col-md-2">
                                <label class="col-form-label summary-label">Pelanggan</label>
                            </div>
                            <div class="col-md-5">
                                <select class="form-select form-select-sm">
                                    <option selected>Umum</option>
                                    <option>Member</option>
                                </select>
                            </div>
                            <div class="col-md-2 text-end">
                                <label class="col-form-label summary-label">No. Member / HP</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control form-control-sm" placeholder="Opsional">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keranjang Belanja Card -->
                <div class="card">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                            <h6 class="card-title m-0">Keranjang Belanja</h6>
                            <span class="badge bg-secondary text-dark bg-opacity-25 rounded-pill px-3">0 Item</span>
                        </div>
                        
                        <div class="table-responsive" style="min-height: 250px;">
                            <table class="table table-cart mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="45%">Barang</th>
                                        <th width="20%" class="text-end">Harga</th>
                                        <th width="10%" class="text-center">Qty</th>
                                        <th width="20%" class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5">
                                            <div class="empty-cart-msg">
                                                Keranjang masih kosong.<br>
                                                Silakan cari atau scan barang.
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel (Payment Summary) -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-title border-bottom pb-2">Ringkasan Pembayaran</h6>
                        
                        <!-- Rincian -->
                        <div class="row mb-2 mt-3">
                            <div class="col-6 summary-label">Total Item</div>
                            <div class="col-6 text-end fw-bold">0</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6 summary-label">Subtotal</div>
                            <div class="col-6 text-end fw-bold">Rp 0</div>
                        </div>
                        
                        <div class="row mb-2 align-items-center">
                            <div class="col-6 summary-label">Diskon (%)</div>
                            <div class="col-6">
                                <input type="number" class="form-control summary-input" value="0">
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <div class="col-6 summary-label">Diskon (Rp)</div>
                            <div class="col-6">
                                <input type="number" class="form-control summary-input" value="0">
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <div class="col-6 summary-label">Pajak / PPN</div>
                            <div class="col-6">
                                <input type="number" class="form-control summary-input" value="0">
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <div class="col-6 summary-label">Biaya Lain</div>
                            <div class="col-6">
                                <input type="number" class="form-control summary-input" value="0">
                            </div>
                        </div>

                        <!-- Total Akhir -->
                        <div class="total-akhir-box">
                            <div class="total-akhir-label">TOTAL AKHIR</div>
                            <h2 class="total-akhir-value">Rp 0</h2>
                        </div>

                        <!-- Payment Box -->
                        <div class="payment-box">
                            <label class="summary-label mb-1">Uang Dibayar</label>
                            <input type="text" class="form-control uang-dibayar-input mb-3" value="0">
                            
                            <label class="summary-label mb-2 d-block">Metode Pembayaran</label>
                            <div class="row g-2 mb-2">
                                <div class="col-4"><button class="btn btn-primary w-100 method-btn">Tunai</button></div>
                                <div class="col-4"><button class="btn btn-outline-secondary w-100 method-btn bg-white">QRIS</button></div>
                                <div class="col-4"><button class="btn btn-outline-secondary w-100 method-btn bg-white">Debit</button></div>
                            </div>
                            <div class="row g-2">
                                <div class="col-4"><button class="btn btn-outline-secondary w-100 method-btn bg-white">Kredit</button></div>
                                <div class="col-4"><button class="btn btn-outline-secondary w-100 method-btn bg-white">E-Wallet</button></div>
                                <div class="col-4"><button class="btn btn-outline-secondary w-100 method-btn bg-white">Transfer</button></div>
                            </div>

                            <!-- Kembalian -->
                            <div class="kembalian-box">
                                <div class="kembalian-label">KEMBALIAN</div>
                                <h3 class="kembalian-value">Rp 0</h3>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-btn-group">
                            <button class="btn btn-warning w-50 fw-bold text-dark">Tahan</button>
                            <button class="btn btn-danger w-50 fw-bold">Batal</button>
                        </div>
                        <button class="btn btn-success btn-bayar">BAYAR & CETAK</button>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <div class="footer-bar">
        <div>Kasir: Admin</div>
        <div>F2 Cari Barang • F4 Bayar • ESC Batal</div>
    </div>

    <!-- Script Midtrans (Trigger saat Bayar) -->
    <script>
    let cart = [];
    let totalAkhir = 0;

    // --- 1. FITUR PENCARIAN BARANG ---
    const searchBtn = document.querySelector('.btn-primary.px-4');
    const searchInput = document.querySelector('input[placeholder="Cari nama barang / kode / barcode..."]');

    searchBtn.addEventListener('click', async function() {
        const keyword = searchInput.value;
        if(!keyword) return alert('Masukkan nama barang yang dicari!');

        try {
            // Memanggil API backend Laravel yang baru dibuat
            const response = await fetch(`/api/products/search?q=${keyword}`);
            const products = await response.json();

            if(products.length > 0) {
                addToCart(products[0]); // Langsung masukkan hasil pertama ke keranjang
                searchInput.value = ''; // Kosongkan input
            } else {
                alert('Barang tidak ditemukan di database!');
            }
        } catch (error) {
            console.error("Error:", error);
            alert('Terjadi kesalahan koneksi database.');
        }
    });

    // --- 2. FITUR KERANJANG BELANJA ---
    function addToCart(product) {
        const existing = cart.find(item => item.id === product.id);
        if(existing) {
            existing.qty += 1;
        } else {
            cart.push({ ...product, qty: 1 });
        }
        renderCart();
    }

    function renderCart() {
        const tbody = document.querySelector('.table-cart tbody');
        tbody.innerHTML = ''; 
        
        totalAkhir = 0;
        let totalItem = 0;

        if(cart.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5"><div class="empty-cart-msg">Keranjang masih kosong.</div></td></tr>`;
        } else {
            cart.forEach((item, index) => {
                const subtotal = item.price * item.qty;
                totalAkhir += subtotal;
                totalItem += item.qty;

                tbody.innerHTML += `
                    <tr>
                        <td class="text-center align-middle">${index + 1}</td>
                        <td class="align-middle">${item.name}</td>
                        <td class="text-end align-middle">Rp ${item.price.toLocaleString('id-ID')}</td>
                        <td class="text-center align-middle">
                            <input type="number" class="form-control form-control-sm text-center" value="${item.qty}" min="1" onchange="updateQty(${index}, this.value)" style="width:60px; margin:auto;">
                        </td>
                        <td class="text-end align-middle">Rp ${subtotal.toLocaleString('id-ID')}</td>
                    </tr>
                `;
            });
        }

        // Update teks di Ringkasan UI
        document.querySelectorAll('.summary-label + div')[0].innerText = totalItem; // Total Item
        document.querySelectorAll('.summary-label + div')[1].innerText = `Rp ${totalAkhir.toLocaleString('id-ID')}`; // Subtotal
        document.querySelector('.total-akhir-value').innerText = `Rp ${totalAkhir.toLocaleString('id-ID')}`;
        hitungKembalian();
    }

    function updateQty(index, newQty) {
        cart[index].qty = parseInt(newQty);
        renderCart();
    }

    // --- 3. LOGIKA KEMBALIAN ---
    const uangInput = document.querySelector('.uang-dibayar-input');
    uangInput.addEventListener('input', hitungKembalian);

    function hitungKembalian() {
        const bayar = parseFloat(uangInput.value) || 0;
        const kembalian = bayar - totalAkhir;
        const kembalianEl = document.querySelector('.kembalian-value');
        
        if (kembalian >= 0 && totalAkhir > 0) {
            kembalianEl.innerText = `Rp ${kembalian.toLocaleString('id-ID')}`;
            kembalianEl.style.color = '#0f5132'; // Hijau
        } else if (bayar > 0 && kembalian < 0) {
            kembalianEl.innerText = "Uang Kurang!";
            kembalianEl.style.color = 'red';
        } else {
            kembalianEl.innerText = "Rp 0";
            kembalianEl.style.color = '#0f5132';
        }
    }

// --- 4. INTEGRASI MIDTRANS & CHECKOUT ---
    document.querySelector('.btn-bayar').addEventListener('click', function() {
        if(cart.length === 0) return alert('Keranjang belanja masih kosong!');
        
        const bayar = parseFloat(uangInput.value) || 0;
        if (bayar < totalAkhir) return alert('Uang pembayaran masih kurang!');

        this.innerHTML = "Memproses...";
        this.disabled = true;

        fetch('/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // PERBAIKAN: Gunakan tag Blade Laravel agar token selalu baru, JANGAN pakai teks hardcode!
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                'Accept': 'application/json'
            },
            body: JSON.stringify({ total: totalAkhir })
        })
        .then(response => {
            return response.json().then(data => {
                if (!response.ok) {
                    throw new Error(data.error || 'Kesalahan Server Internal');
                }
                return data;
            });
        })
        .then(data => {
            const btn = document.querySelector('.btn-bayar');
            btn.innerHTML = "BAYAR & CETAK";
            btn.disabled = false;

            if(data.snap_token) {
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        alert("Pembayaran lunas! Struk akan otomatis tercetak.");
                        cart = []; 
                        renderCart();
                        uangInput.value = '0';
                    }
                });
            }
        })
        .catch(error => {
            // PERBAIKAN: Alert ini sekarang akan memunculkan apa error aslinya di layar Anda!
            alert('GAGAL CHECKOUT: \n' + error.message);
            document.querySelector('.btn-bayar').innerHTML = "BAYAR & CETAK";
            document.querySelector('.btn-bayar').disabled = false;
        });
    });

</script>
</body>
</html>