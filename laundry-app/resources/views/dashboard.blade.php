@extends('layouts.app')

@section('content')

<style>
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .dashboard-header h1 {
        margin: 0;
        color: #172554;
        font-size: 26px;
    }

    .dashboard-header p {
        color: #64748b;
        margin-top: 6px;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: white;
        padding: 22px;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,.05);
        border: 1px solid #e5e7eb;
    }

    .stat-card .stat-icon {
        font-size: 25px;
        margin-bottom: 15px;
    }

    .stat-card h2 {
        margin: 0;
        font-size: 25px;
        color: #172554;
    }

    .stat-card p {
        color: #64748b;
        margin-bottom: 0;
        font-size: 14px;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .dashboard-panel {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
    }

    .dashboard-panel h3 {
        color: #172554;
        margin-top: 0;
    }

    .chart {
        height: 220px;
        display: flex;
        align-items: end;
        justify-content: space-around;
        gap: 15px;
        padding-top: 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .chart-column {
        flex: 1;
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: end;
        align-items: center;
    }

    .chart-bar {
        width: 65%;
        min-height: 3px;
        background: #3b82f6;
        border-radius: 6px 6px 0 0;
    }

    .chart-column span {
        color: #64748b;
        font-size: 12px;
        margin-top: 8px;
    }

    .status-item {
        display: flex;
        justify-content: space-between;
        padding: 13px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .status-item strong {
        color: #172554;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .dashboard-table th,
    .dashboard-table td {
        text-align: left;
        padding: 14px;
        border-bottom: 1px solid #e5e7eb;
    }

    .dashboard-table th {
        color: #64748b;
        font-size: 13px;
        background: #f8fafc;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        background: #eff6ff;
        color: #2563eb;
    }

    @media(max-width: 900px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 500px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-header">
    <div>
        <h1>Dashboard</h1>
        <p>Selamat datang di sistem manajemen LaundryKu.</p>
    </div>

    <div>
        <strong>{{ now()->translatedFormat('l, d F Y') }}</strong>
    </div>
</div>

{{-- Statistik --}}
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <h2>{{ number_format($totalPelanggan) }}</h2>
        <p>Total Pelanggan</p>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🧾</div>
        <h2>{{ number_format($totalTransaksi) }}</h2>
        <p>Total Transaksi</p>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🧺</div>
        <h2>{{ number_format($transaksiDiproses) }}</h2>
        <p>Sedang Diproses</p>
    </div>

    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <h2 style="font-size: 21px">
            Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
        </h2>
        <p>Pendapatan Bulan Ini</p>
    </div>

</div>

{{-- Grafik dan Status --}}
<div class="dashboard-grid">

    <div class="dashboard-panel">
        <h3>Grafik Pendapatan</h3>
        <p style="color:#64748b;font-size:13px">
            Pendapatan enam bulan terakhir
        </p>

        @php
            $maksimal = max($pendapatanBulanan->max('total'), 1);
        @endphp

        <div class="chart">
            @foreach($pendapatanBulanan as $data)
                <div class="chart-column">

                    <div class="chart-bar"
                         style="height: {{ ($data['total'] / $maksimal) * 100 }}%">
                    </div>

                    <span>{{ $data['bulan'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="dashboard-panel">
        <h3>Status Transaksi</h3>

        <div class="status-item">
            <span>Menunggu</span>
            <strong>
                {{ \App\Models\Transaksi::where('status', 'Menunggu')->count() }}
            </strong>
        </div>

        <div class="status-item">
            <span>Sedang Diproses</span>
            <strong>{{ $transaksiDiproses }}</strong>
        </div>

        <div class="status-item">
            <span>Siap Diambil</span>
            <strong>
                {{ \App\Models\Transaksi::where('status', 'Siap Diambil')->count() }}
            </strong>
        </div>

        <div class="status-item">
            <span>Selesai</span>
            <strong>{{ $transaksiSelesai }}</strong>
        </div>
    </div>

</div>

{{-- Transaksi Terbaru --}}
<div class="dashboard-panel">

    <h3>Transaksi Terbaru</h3>

    <div class="table-wrapper">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Status Laundry</th>
                    <th>Pembayaran</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transaksiTerbaru as $item)
                    <tr>
                        <td>
                            TRX-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        <td>{{ $item->pelanggan->nama }}</td>

                        <td>{{ $item->tanggal }}</td>

                        <td>
                            Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                        </td>

                        <td>
                            <span class="status-badge">
                                {{ $item->status }}
                            </span>
                        </td>

                        <td>
                            @if($item->pembayaran)
                                <span style="color:green">Lunas</span>
                            @else
                                <span style="color:#d97706">Belum Dibayar</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            Belum ada transaksi laundry.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <br>

    <a href="{{ route('transaksi.index') }}" class="button">
        Lihat Semua Transaksi
    </a>

</div>

@endsection
