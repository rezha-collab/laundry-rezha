@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Ubah Status Transaksi</h2>

    <p>
        Kode Transaksi:
        TRX-{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}
    </p>

    <p>Pelanggan: {{ $transaksi->pelanggan->nama }}</p>

    <form action="{{ route('transaksi.update', $transaksi->id) }}"
          method="POST">
        @csrf
        @method('PUT')

        <label>Status Laundry</label>
        <select name="status" required>
            @foreach([
                'Menunggu',
                'Diproses',
                'Dicuci',
                'Disetrika',
                'Siap Diambil',
                'Selesai'
            ] as $status)
                <option value="{{ $status }}"
                    {{ $transaksi->status == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>

        <br><br>
        <button type="submit">Simpan Status</button>
        <a href="{{ route('transaksi.index') }}">Kembali</a>
    </form>
</div>
@endsection
