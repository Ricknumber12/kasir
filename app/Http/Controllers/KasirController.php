<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class KasirController extends Controller
{
    public function index()
    {
        return view('kasir.index');
    }

    public function store(Request $request)
    {
        $transaction = Transaction::create([
            'transaction_number' => 'TRX-' . now()->format('YmdHis'),
            'customer_id' => $request->customer_id,
            'subtotal' => $request->subtotal,
            'discount' => $request->discount,
            'tax' => $request->tax,
            'other_fee' => $request->other_fee,
            'grand_total' => $request->grand_total,
            'paid_amount' => $request->paid_amount,
            'change_amount' => $request->change_amount,
            'payment_method' => $request->payment_method,
            'status' => 'paid',
        ]);

        foreach ($request->items as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['id'],
                'product_code' => $item['code'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil disimpan!');
    }
}
