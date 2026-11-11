<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - LaundryKu</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #263445;
        }

        .sidebar {
            width: 230px;
            height: 100vh;
            background: #172b4d;
            color: white;
            position: fixed;
            padding: 25px 15px;
        }

        .sidebar h2 {
            font-size: 21px;
            margin: 0 0 30px;
        }

        .sidebar a {
            display: block;
            color: #dce6f5;
            text-decoration: none;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 7px;
        }

        .sidebar a:hover {
            background: #29466f;
            color: white;
        }

        .main {
            margin-left: 230px;
            padding: 30px;
        }

        .header {
            background: white;
            padding: 18px 22px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .content {
            background: white;
            padding: 25px;
            border-radius: 10px;
            min-height: 300px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 18px;
        }

        .card {
            padding: 22px;
            border-radius: 10px;
            background: #eaf2ff;
        }

        .card h3 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f1f5f9;
        }

        .button {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 6px;
        }

        @media (max-width: 700px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <h2>🧺 LaundryKu</h2>

        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('pelanggan.index') }}">Pelanggan</a>
        <a href="{{ route('layanan.index') }}">Layanan</a>
        <a href="{{ route('transaksi.index') }}">Transaksi</a>
        <a href="{{ route('pembayaran.index') }}">Pembayaran</a>
        
    </aside>

    <main class="main">
        <div class="header">
            <strong>Sistem Informasi Manajemen Laundry</strong>
        </div>

        <section class="content">
            @yield('content')
        </section>
    </main>

</body>
</html>
