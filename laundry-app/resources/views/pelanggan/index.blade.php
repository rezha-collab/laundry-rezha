@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')

<h2>Data Pelanggan</h2>
<p>Kelola seluruh data pelanggan laundry.</p>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<a href="{{ route('pelanggan.create') }}" class="button">
    + Tambah Pelanggan
</a>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No. HP</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($pelanggan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->no_hp }}</td>
                <td>{{ $item->alamat ?? '-' }}</td>
                <td>
                    <a href="{{ route('pelanggan.edit', $item->id) }}">
                        Edit
                    </a>

                    <form action="{{ route('pelanggan.destroy', $item->id) }}"
                          method="POST"
                          style="display:inline"
                          onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Belum ada data pelanggan.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
