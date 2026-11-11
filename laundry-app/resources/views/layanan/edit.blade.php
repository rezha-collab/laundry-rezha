@extends('layouts.app')

@section('title', 'Edit Layanan')

@section('content')

<h2>Edit Layanan Laundry</h2>

<form action="{{ route('layanan.update', $layanan->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <p>Nama Layanan</p>
    <input type="text"
           name="nama_layanan"
           value="{{ old('nama_layanan', $layanan->nama_layanan) }}"
           required>

    @error('nama_layanan')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <p>Harga per Kg</p>
    <input type="number"
           name="harga_per_kg"
           value="{{ old('harga_per_kg', $layanan->harga_per_kg) }}"
           min="0"
           step="0.01"
           required>

    @error('harga_per_kg')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <p>Deskripsi</p>
    <textarea name="deskripsi">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>

    @error('deskripsi')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <br><br>

    <button type="submit" class="button">Update</button>
    <a href="{{ route('layanan.index') }}">Kembali</a>

</form>

@endsection
