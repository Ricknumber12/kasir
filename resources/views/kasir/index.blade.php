<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Retail POS</title>
    <!-- Memanggil Bootstrap 5 dari CDN untuk kemudahan (atau sesuaikan dengan instalasi lokal Anda) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Memanggil CSS kustom[cite: 3, 4] -->
    <link rel="stylesheet" href="{{ asset('css/chasier.css') }}">
</head>
<body style="background-color: #f4f6f9;">

<div class="container-fluid py-3">
    <!-- HEADER -->
    <header class="d-flex justify-content-between align-items-center bg-white p-3 mb-3 rounded shadow-sm border">
        <div>
            <h4 class="mb-0 fw-bold text-primary">TOKO SAYA</h4>
            <small class="text-muted">Jl. Katulistiwa No. 123 Jember - Telp. 0812-xxxx-xxxx</small>
        </div>
        <div class="text-end">
            <div class="small text-muted">No. Transaksi</div>
            <div class="fw-bold fs-5 text-dark" id="transactionNumber">
                {{ $transaction_number ?? 'TRX-20260911-001' }}
            </div>
            <div class="small fw-bold text-secondary" id="currentDate"></div>
        </div>
    </header>

    <!-- MAIN[cite: 4] -->
    <div class="row g-3">
        
        <!--================= LEFT =================[cite: 4]-->
        <div class="col-lg-8">
            
            <!-- SEARCH[cite: 5] -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold py-3">Tambah Barang</div>
                <div class="card-body">
                    <div class="row g-2 mb-3 align-items-center">
                        <div class="col-md-10 position-relative">
                            <input type="text" id="searchProduct" class="form-control form-control-lg" placeholder="Cari nama barang / kode / barcode (F2)..." autocomplete="off">
                            <div class="product-results bg-white border rounded shadow position-absolute w-100" id="productResults" style="display: none; z-index: 1000; top: 100%; max-height: 250px; overflow-y: auto;"></div>
                        </div>
                        <div class="col-md-2 d-grid">
                            <button class="btn btn-primary btn-lg" onclick="searchProduct()">Cari</button>
                        </div>
                    </div>
                    
                    <!-- CUSTOMER[cite: 5] -->
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small mb-1">Pelanggan</label>
                            <select class="form-select">
                                <option>Umum</option>
                                <option>Pelanggan Member</option>
                                <option>Member VIP</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small mb-1">No. Member / HP</label>
                            <input type="text" class="form-control" placeholder="Opsional">
                        </div>
                    </div>
                </div>
            </div>

            <!-- CART[cite: 6] -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center fw-bold">
                    <span>Keranjang Belanja</span>
                    <span class="badge bg-primary rounded-pill px-3 py-2" id="itemCount">0 Item</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th>Barang</th>
                                <th width="15%">Harga</th>
                                <th width="20%" class="text-center">Qty</th>
                                <th width="20%" class="text-end">Subtotal</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody id="cartBody">
                            <!-- JS akan merender baris ini[cite: 6, 14] -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--================= RIGHT =================[cite: 4]-->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <!-- PAYMENT SUMMARY[cite: 8] -->
                <div class="card-header bg-white py-3 fw-bold">Ringkasan Pembayaran</div>
                <div class="card-body">
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Item</span>
                        <strong id="totalQty">0</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <strong id="subtotal">Rp 0</strong>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="small text-muted">Diskon (%)</label>
                            <input type="number" id="discountPercent" class="form-control form-control-sm text-end" value="0" min="0" max="100" onchange="calculateTotal()">
                        </div>
                        <div class="col-6">
                            <label class="small text-muted">Diskon (Rp)</label>
                            <input type="number" id="discountAmount" class="form-control form-control-sm text-end" value="0" min="0" onchange="calculateTotal()">
                        </div>
                        <div class="col-6">
                            <label class="small text-muted">Pajak / PPN</label>
                            <input type="number" id="tax" class="form-control form-control-sm text-end" value="0" min="0" onchange="calculateTotal()">
                        </div>
                        <div class="col-6">
                            <label class="small text-muted">Biaya Lain</label>
                            <input type="number" id="otherFee" class="form-control form-control-sm text-end" value="0" min="0" onchange="calculateTotal()">
                        </div>
                    </div>

                    <!-- TOTAL[cite: 8] -->
                    <div class="bg-light p-3 rounded mb-3 text-end border">
                        <div class="small text-muted mb-1">TOTAL AKHIR</div>
                        <h2 class="mb-0 fw-bold text-dark" id="grandTotal">Rp 0</h2>
                    </div>

                    <!-- PAYMENT[cite: 9] -->
                    <div class="bg-primary bg-opacity-10 p-3 rounded border border-primary border-opacity-25 mb-3">
                        <label class="fw-bold mb-2 text-primary">Uang Dibayar (F4)</label>
                        <input type="number" id="payment" class="form-control form-control-lg text-end fw-bold mb-3" placeholder="0" oninput="calculateChange()">
                        
                        <label class="small fw-bold mb-2">Metode Pembayaran</label>
                        <div class="d-flex flex-wrap gap-2 payment-method">
                            <button class="btn btn-outline-primary btn-sm active" onclick="selectPayment(this)">Tunai</button>
                            <button class="btn btn-outline-primary btn-sm" onclick="selectPayment(this)">QRIS</button>
                            <button class="btn btn-outline-primary btn-sm" onclick="selectPayment(this)">Debit</button>
                            <button class="btn btn-outline-primary btn-sm" onclick="selectPayment(this)">Transfer</button>
                        </div>
                    </div>

                    <!-- CHANGE[cite: 9] -->
                    <div class="p-3 rounded text-end mb-3 change-box bg-success bg-opacity-10 border border-success border-opacity-25" id="changeBox">
                        <div class="small fw-bold text-success change-label">KEMBALIAN</div>
                        <h3 class="mb-0 fw-bold text-success" id="change">Rp 0</h3>
                    </div>

                    <!-- ACTION[cite: 10] -->
                    <div class="row g-2">
                        <div class="col-6">
                            <button class="btn btn-warning w-100 fw-bold" onclick="holdTransaction()">Tahan</button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-danger w-100 fw-bold" onclick="cancelTransaction()">Batal (ESC)</button>
                        </div>
                        <div class="col-12 mt-2">
                            <button class="btn btn-success w-100 btn-lg fw-bold" onclick="processPayment()">BAYAR & CETAK</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Memanggil Javascript kustom[cite: 19] -->
<script src="{{ asset('js/chasier.js') }}"></script>
</body>
</html>