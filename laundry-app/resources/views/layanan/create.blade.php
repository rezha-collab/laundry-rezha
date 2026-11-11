@extends('layouts.app')

@section('title', 'Tambah Layanan')

@section('content')

<h2>Tambah Layanan Laundry</h2>

<form action="{{ route('layanan.store') }}" method="POST">
    @csrf

    <p>Nama Layanan</p>
    <input type="text"
           name="nama_layanan"
           value="{{ old('nama_layanan') }}"
           placeholder="Contoh: Cuci Setrika"
           required>

    @error('nama_layanan')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <p>Harga per Kg</p>
    <input type="number"
           name="harga_per_kg"
           value="{{ old('harga_per_kg') }}"
           min="0"
           step="0.01"
           placeholder="Contoh: 7000"
           required>

    @error('harga_per_kg')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <p>Deskripsi</p>
    <textarea name="deskripsi"
              placeholder="Deskripsi layanan">{{ old('deskripsi') }}</textarea>

    @error('deskripsi')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <br><br>

    <button type="submit" class="button">Simpan</button>
    <a href="{{ route('layanan.index') }}">Kembali</a>

</form>

@endsection
