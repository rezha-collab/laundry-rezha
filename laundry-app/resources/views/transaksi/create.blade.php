@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Tambah Transaksi Laundry</h2>

    @if($errors->any())
        <div style="color: red">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf

        <label>Pelanggan</label>
        <select name="pelanggan_id" required>
            <option value="">-- Pilih Pelanggan --</option>
            @foreach($pelanggan as $item)
                <option value="{{ $item->id }}"
                    {{ old('pelanggan_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->nama }}
                </option>
            @endforeach
        </select>

        <label>Tanggal Transaksi</label>
        <input type="date" name="tanggal"
               value="{{ old('tanggal', date('Y-m-d')) }}" required>

        <h3>Detail Layanan</h3>

        <div id="detail-container">
            <div class="detail-row">
                <label>Layanan</label>
                <select name="layanan_id[]" required>
                    <option value="">-- Pilih Layanan --</option>
                    @foreach($layanan as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama_layanan }} -
                            Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}/kg
                        </option>
                    @endforeach
                </select>

                <label>Berat (kg)</label>
                <input type="number" name="berat[]"
                       min="0.1" step="0.1" placeholder="Contoh: 3.5" required>
            </div>
        </div>

        <button type="button" onclick="tambahDetail()">
            + Tambah Layanan
        </button>

        <br><br>
        <button type="submit">Simpan Transaksi</button>
        <a href="{{ route('transaksi.index') }}">Kembali</a>
    </form>
</div>

<script>
function tambahDetail() {
    const container = document.getElementById('detail-container');
    const baris = container.querySelector('.detail-row').cloneNode(true);

    baris.querySelectorAll('select, input').forEach(function(input) {
        input.value = '';
    });

    container.appendChild(baris);
}
</script>
@endsection
