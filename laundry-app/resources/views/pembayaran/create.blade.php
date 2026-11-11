@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Pembayaran Laundry</h2>

    <p>
        <strong>Kode Transaksi:</strong>
        TRX-{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}
    </p>

    <p>
        <strong>Pelanggan:</strong>
        {{ $transaksi->pelanggan->nama }}
    </p>

    <p>
        <strong>Total Tagihan:</strong>
        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
    </p>

    @if($errors->any())
        <div style="color:red">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('pembayaran.store', $transaksi->id) }}"
          method="POST">
        @csrf

        <label>Metode Pembayaran</label>

        <select name="metode" required>
            <option value="">-- Pilih Metode --</option>
            <option value="Tunai">Tunai</option>
            <option value="Transfer">Transfer</option>
            <option value="QRIS">QRIS</option>
        </select>

        <br><br>

        <button type="submit"
            onclick="return confirm('Simpan pembayaran ini?')">
            Konfirmasi Pembayaran
        </button>

        <a href="{{ route('transaksi.show', $transaksi->id) }}">
            Kembali
        </a>
    </form>
</div>
@endsection
