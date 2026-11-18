<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Order;
use Exception;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        try {
            // --- CARA PINTAS: Masukkan Server Key langsung di sini! ---
            Config::$serverKey = 'SB-Mid-server-rfbXv-i_roEIT_7uesrh9MHU'; 
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $totalAkhir = $request->input('total');
            if (!$totalAkhir) {
                return response()->json(['error' => 'Total tidak valid'], 400);
            }

            // Simpan pesanan ke database
            $order = Order::create([
                'customer_id' => 1,
                'order_date'  => now()->toDateString(),
                'total_price' => $totalAkhir,
                'discount'    => 0,
                'status'      => 'pending',
                'shipping_fee'=> 0
            ]);

            $midtransOrderId = 'TRX-' . $order->order_id . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id'     => $midtransOrderId,
                    'gross_amount' => $totalAkhir,
                ],
                'customer_details' => [
                    'first_name' => 'Pelanggan',
                    'last_name'  => 'Umum',
                ]
            ];

            // Request Snap Token
            $snapToken = Snap::getSnapToken($params);
            
            return response()->json(['snap_token' => $snapToken]);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}