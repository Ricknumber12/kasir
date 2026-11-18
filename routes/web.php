<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;

Route::view('/', 'kasir');

// Route untuk fitur pencarian kasir
Route::get('/api/products/search', function (Request $request) {
    $keyword = $request->query('q');
    
    // Mencari barang di tabel products berdasarkan kolom name
    $products = Product::where('name', 'LIKE', "%{$keyword}%")->get();
    
    // Menyesuaikan format data (karena tabel Anda memakai 'product_id' bukan 'id')
    $formattedProducts = $products->map(function($item) {
        return [
            'id' => $item->product_id,
            'name' => $item->name,
            'price' => $item->price
        ];
    });
    
    return response()->json($formattedProducts);
});

// Endpoint yang menerima total harga dari kasir.blade.php
Route::post('/checkout', [TransactionController::class, 'checkout']);




// Menampilkan halaman tombol bayar
Route::get('/checkout', function () {
    return view('checkout');
});



// Endpoint untuk memproses token Midtrans
Route::post('/checkout', [TransactionController::class, 'checkout']);

// Endpoint untuk menerima notifikasi otomatis (webhook) dari Midtrans
Route::post('/midtrans/notification', [TransactionController::class, 'notification']);

Route::get('/kasir', function () {
    return view('kasir');
});

Route::post('/checkout', function (Request $request) {
    // 1. Tangkap angka total harga yang dikirim dari JavaScript kasir
    $totalAkhir = $request->input('total');

    // 2. Simpan data transaksi ke tabel orders
    $order = Order::create([
        'customer_id' => 1, // Anggap 1 adalah ID pelanggan umum
        'order_date' => now()->toDateString(),
        'total_price' => $totalAkhir, // Sekarang variabel ini punya nilai
        'discount' => 0,
        'status' => 'pending',
        'shipping_fee' => 0
    ]);

    // 3. Konfigurasi Midtrans
    \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    // 4. Siapkan parameter untuk dikirim ke Midtrans
    $params = array(
        'transaction_details' => array(
            // Gunakan order_id yang baru saja dibuat di database
            'order_id' => $order->order_id . '-' . time(), // Ditambah time() agar unik saat diuji berkali-kali
            'gross_amount' => $totalAkhir,
        ),
        'customer_details' => array(
            'first_name' => 'Pelanggan',
            'last_name' => 'Umum',
        ),
    );

    // 5. Minta Snap Token ke Midtrans
    $snapToken = \Midtrans\Snap::getSnapToken($params);

    // 6. Kembalikan token ke frontend (kasir.blade.php)
    return response()->json(['snap_token' => $snapToken]);
});

// ACARA 38: Midtrans
Route::post('/checkout', [TransactionController::class, 'checkout']);
Route::post('/midtrans/notification', [TransactionController::class, 'notification']);