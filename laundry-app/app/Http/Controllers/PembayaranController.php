<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::with([
            'transaksi.pelanggan'
        ])->latest()->get();

        return view('pembayaran.index', compact('pembayaran'));
    }

    public function create(Transaksi $transaksi)
    {
        $transaksi->load('pembayaran', 'pelanggan');

        if ($transaksi->pembayaran) {
            return redirect()->route('transaksi.show', $transaksi->id)
                ->with('error', 'Transaksi ini sudah dibayar.');
        }

        return view('pembayaran.create', compact('transaksi'));
    }

    public function store(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'metode' => 'required|in:Tunai,Transfer,QRIS',
        ]);

        if ($transaksi->pembayaran) {
            return redirect()->route('transaksi.show', $transaksi->id)
                ->with('error', 'Transaksi ini sudah dibayar.');
        }

        Pembayaran::create([
            'transaksi_id' => $transaksi->id,
            'tanggal_bayar' => now(),
            'jumlah_bayar' => $transaksi->total_harga,
            'metode' => $validated['metode'],
        ]);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil disimpan.');
    }
}
