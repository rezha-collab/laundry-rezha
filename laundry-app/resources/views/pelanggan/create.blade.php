@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')

<h2>Tambah Pelanggan</h2>

<form action="{{ route('pelanggan.store') }}" method="POST">
    @csrf

    <p>Nama Pelanggan</p>
    <input type="text" name="nama"
           value="{{ old('nama') }}"
           placeholder="Masukkan nama pelanggan"
           required>

    @error('nama')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <p>Nomor HP</p>
    <input type="text" name="no_hp"
           value="{{ old('no_hp') }}"
           placeholder="Masukkan nomor HP"
           required>

    @error('no_hp')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <p>Alamat</p>
    <textarea name="alamat"
              placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>

    @error('alamat')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <br><br>

    <button type="submit" class="button">Simpan</button>
    <a href="{{ route('pelanggan.index') }}">Kembali</a>
</form>

@endsection
