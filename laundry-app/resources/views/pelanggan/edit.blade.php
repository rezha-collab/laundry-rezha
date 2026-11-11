@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')

<h2>Edit Data Pelanggan</h2>

<form action="{{ route('pelanggan.update', $pelanggan->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <p>Nama Pelanggan</p>
    <input type="text" name="nama"
           value="{{ old('nama', $pelanggan->nama) }}"
           required>

    @error('nama')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <p>Nomor HP</p>
    <input type="text" name="no_hp"
           value="{{ old('no_hp', $pelanggan->no_hp) }}"
           required>

    @error('no_hp')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <p>Alamat</p>
    <textarea name="alamat">{{ old('alamat', $pelanggan->alamat) }}</textarea>

    @error('alamat')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <br><br>

    <button type="submit" class="button">Update</button>
    <a href="{{ route('pelanggan.index') }}">Kembali</a>

</form>

@endsection
