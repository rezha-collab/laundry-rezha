@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Data Transaksi Laundry</h2>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red">{{ session('error') }}</p>
    @endif

    <a href="{{ route('transaksi.create') }}" class="button">
        + Tambah Transaksi
    </a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Berat</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($transaksi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>TRX-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $item->pelanggan->nama }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ number_format($item->total_berat, 2) }} kg</td>
                    <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        <a href="{{ route('transaksi.show', $item->id) }}">
                            Detail
                        </a>

                        @if(!$item->pembayaran)
                            <a href="{{ route('pembayaran.create', $item->id) }}"
                                 class="button">
                                 Bayar
                            </a>
                        @else
                            <span style="color:green">Lunas</span>
                        @endif

                        <a href="{{ route('transaksi.edit', $item->id) }}">
                            Ubah Status
                        </a>

                        <form action="{{ route('transaksi.destroy', $item->id) }}"
                                method="POST"
                                onsubmit="return confirm('Hapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada transaksi laundry.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
