@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Data Pembayaran</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Pelanggan</th>
                <th>Tanggal Bayar</th>
                <th>Jumlah Bayar</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($pembayaran as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    TRX-{{ str_pad($item->transaksi_id, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td>{{ $item->transaksi->pelanggan->nama }}</td>
                <td>{{ $item->tanggal_bayar }}</td>
                <td>
                    Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}
                </td>
                <td>{{ $item->metode }}</td>
                <td>Lunas</td>
            </tr>
            @empty
            <tr>
                <td colspan="7">Belum ada pembayaran.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
