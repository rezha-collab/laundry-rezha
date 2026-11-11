@extends('layouts.app')

@section('title', 'Data Layanan')

@section('content')

<h2>Data Layanan Laundry</h2>
<p>Kelola jenis layanan dan harga laundry.</p>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<a href="{{ route('layanan.create') }}" class="button">
    + Tambah Layanan
</a>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Layanan</th>
            <th>Harga per Kg</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($layanan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_layanan }}</td>
                <td>Rp{{ number_format($item->harga_per_kg, 0, ',', '.') }}</td>
                <td>{{ $item->deskripsi ?? '-' }}</td>
                <td>
                    <a href="{{ route('layanan.edit', $item->id) }}">
                        Edit
                    </a>

                    <form action="{{ route('layanan.destroy', $item->id) }}"
                          method="POST"
                          style="display:inline"
                          onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Belum ada layanan laundry.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
