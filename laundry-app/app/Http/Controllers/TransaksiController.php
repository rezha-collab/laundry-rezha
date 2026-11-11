<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TransaksiController extends Controller
{   
    public function show(Transaksi $transaksi)
    {
         $transaksi->load([
            'pelanggan',
            'user',
            'detailTransaksi.layanan',
            'pembayaran'
        ]);

        return view('transaksi.show', compact('transaksi'));
    }
    public function index()
    {
        $transaksi = Transaksi::with([
            'pelanggan',
            'user',
            'detailTransaksi.layanan',
            'pembayaran'
        ])->latest()->get();

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::orderBy('nama')->get();
        $layanan = Layanan::orderBy('nama_layanan')->get();

        return view('transaksi.create', compact('pelanggan', 'layanan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'tanggal' => 'required|date',
            'layanan_id' => 'required|array|min:1',
            'layanan_id.*' => 'required|exists:layanan,id',
            'berat' => 'required|array|min:1',
            'berat.*' => 'required|numeric|min:0.1',
        ]);

        if (count($validated['layanan_id']) !== count($validated['berat'])) {
            return back()->withInput()->withErrors([
                'berat' => 'Jumlah layanan dan berat tidak sesuai.'
            ]);
        }

        // Ambil ID petugas yang sedang login.
        // Jika autentikasi belum dibuat, gunakan user pertama.
        $userId = auth()->id() ?? User::query()->value('id');

        if (!$userId) {
            return back()->withInput()->withErrors([
                'pelanggan_id' => 'Belum ada akun petugas. Buat akun terlebih dahulu.'
            ]);
        }

        DB::transaction(function () use ($validated, $userId) {
            $totalBerat = 0;
            $totalHarga = 0;

            $transaksi = Transaksi::create([
                'pelanggan_id' => $validated['pelanggan_id'],
                'user_id' => $userId,
                'tanggal' => $validated['tanggal'],
                'total_berat' => 0,
                'total_harga' => 0,
                'status' => 'Menunggu',
            ]);

            foreach ($validated['layanan_id'] as $index => $layananId) {
                $layanan = Layanan::findOrFail($layananId);
                $berat = (float) $validated['berat'][$index];
                $harga = (float) $layanan->harga_per_kg;
                $subtotal = $berat * $harga;

                $transaksi->detailTransaksi()->create([
                    'layanan_id' => $layanan->id,
                    'berat' => $berat,
                    'harga' => $harga,
                    'subtotal' => $subtotal,
                ]);

                $totalBerat += $berat;
                $totalHarga += $subtotal;
            }

            $transaksi->update([
                'total_berat' => $totalBerat,
                'total_harga' => $totalHarga,
            ]);
        });

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaksi $transaksi)
    {
        $transaksi->load('detailTransaksi');
        $pelanggan = Pelanggan::orderBy('nama')->get();
        $layanan = Layanan::orderBy('nama_layanan')->get();

        return view('transaksi.edit', compact(
            'transaksi', 'pelanggan', 'layanan'
        ));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Dicuci,Disetrika,Siap Diambil,Selesai',
        ]);

        $transaksi->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
