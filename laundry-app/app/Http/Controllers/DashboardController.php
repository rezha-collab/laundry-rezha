<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = Pelanggan::count();

        $totalTransaksi = Transaksi::count();

        $transaksiDiproses = Transaksi::whereIn('status', [
            'Diproses',
            'Dicuci',
            'Disetrika'
        ])->count();

        $transaksiSelesai = Transaksi::where('status', 'Selesai')
            ->count();

        $pendapatanBulanIni = Pembayaran::whereMonth(
            'tanggal_bayar',
            now()->month
        )->whereYear(
            'tanggal_bayar',
            now()->year
        )->sum('jumlah_bayar');

        $transaksiTerbaru = Transaksi::with([
            'pelanggan',
            'pembayaran'
        ])->latest()->take(5)->get();

        // Data pendapatan enam bulan terakhir
        $pendapatanBulanan = collect(range(5, 0))->map(function ($i) {
            $bulan = now()->subMonths($i);

            $total = Pembayaran::whereYear(
                'tanggal_bayar',
                $bulan->year
            )->whereMonth(
                'tanggal_bayar',
                $bulan->month
            )->sum('jumlah_bayar');

            return [
                'bulan' => $bulan->translatedFormat('M'),
                'total' => (float) $total
            ];
        });

        return view('dashboard', compact(
            'totalPelanggan',
            'totalTransaksi',
            'transaksiDiproses',
            'transaksiSelesai',
            'pendapatanBulanIni',
            'transaksiTerbaru',
            'pendapatanBulanan'
        ));
    }
}
