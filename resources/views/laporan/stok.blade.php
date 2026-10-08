<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Stok Aset</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            color: #212529;
        }

        .container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0 0 8px;
            font-size: 28px;
        }

        .header p {
            margin: 0;
            color: #6c757d;
            font-size: 15px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .summary-card {
            background: #ffffff;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .summary-card .label {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .summary-card .value {
            font-size: 28px;
            font-weight: bold;
        }

        .table-card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .table-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e9ecef;
        }

        .table-header h2 {
            margin: 0;
            font-size: 18px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px 16px;
            border-bottom: 1px solid #e9ecef;
            text-align: left;
            white-space: nowrap;
        }

        th {
            background: #f8f9fa;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        td {
            font-size: 14px;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-baik {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-ringan {
            background: #fff3cd;
            color: #664d03;
        }

        .badge-berat {
            background: #f8d7da;
            color: #842029;
        }

        .total-row {
            background: #f8f9fa;
            font-weight: bold;
        }

        .empty {
            padding: 40px;
            text-align: center;
            color: #6c757d;
        }

        .footer {
            margin-top: 20px;
            color: #6c757d;
            font-size: 13px;
            text-align: right;
        }

        .filter-card {
            background: #ffffff;
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .filter-header {
            margin-bottom: 20px;
        }

        .filter-header h2 {
            margin: 0;
            font-size: 18px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        .filter-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            background: #ffffff;
            font-size: 14px;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-primary {
            background: #0d6efd;
            color: #ffffff;
        }

        .btn-secondary {
            background: #6c757d;
            color: #ffffff;
        }

        .btn-print {
            background: #198754;
            color: #ffffff;
        }

        @media (max-width: 768px) {
            .summary {
                grid-template-columns: 1fr;
            }

            .container {
                margin: 20px auto;
            }

            .header h1 {
                font-size: 23px;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }
        }

        @media print {
            body {
                background: #ffffff;
            }

            .container {
                max-width: none;
                margin: 0;
                padding: 0;
            }

            .header,
            .summary-card,
            .table-card {
                box-shadow: none;
            }

            .header {
                border-bottom: 2px solid #000;
                border-radius: 0;
            }

            .summary {
                grid-template-columns: repeat(3, 1fr);
            }

            .table-card {
                border-radius: 0;
            }

            .print-hidden {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        {{-- Header --}}
        <div class="header">
            <div class="header-content">
                <div>
                    <h1>Laporan Stok Aset</h1>
                    <p>Laporan stok aktual aset berdasarkan lokasi dan kondisi.</p>
                </div>

                {{-- Tombol Kembali ke Dashboard --}}
                <a href="{{ url('/admin') }}" class="btn btn-secondary print-hidden">
                    🏠 Kembali ke Dashboard
                </a>
            </div>
        </div>

        {{-- Ringkasan --}}
        @php
            $totalStok = $stocks->sum('jumlah');
            $totalJenisAset = $stocks->pluck('asset_id')->unique()->count();
            $totalLokasi = $stocks->pluck('location_id')->unique()->count();
        @endphp

        <div class="summary">

            <div class="summary-card">
                <div class="label">Total Jenis Aset</div>
                <div class="value">
                    {{ $totalJenisAset }}
                </div>
            </div>

            <div class="summary-card">
                <div class="label">Total Stok Aktual</div>
                <div class="value">
                    {{ $totalStok }}
                </div>
            </div>

            <div class="summary-card">
                <div class="label">Lokasi Memiliki Stok</div>
                <div class="value">
                    {{ $totalLokasi }}
                </div>
            </div>

        </div>

        {{-- Filter --}}
        <div class="filter-card print-hidden">

            <div class="filter-header">
                <h2>Filter Laporan</h2>
            </div>

            <form method="GET" action="{{ route('laporan.stok') }}">

                <div class="filter-grid">

                    {{-- Lokasi --}}
                    <div class="filter-group">
                        <label for="location_id">
                            Lokasi
                        </label>

                        <select name="location_id" id="location_id">
                            <option value="">
                                Semua Lokasi
                            </option>

                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}" @selected(request('location_id') == $location->id)>
                                    {{ $location->nama_lokasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kondisi --}}
                    <div class="filter-group">
                        <label for="condition_id">
                            Kondisi
                        </label>

                        <select name="condition_id" id="condition_id">
                            <option value="">
                                Semua Kondisi
                            </option>

                            @foreach ($conditions as $condition)
                                <option value="{{ $condition->id }}" @selected(request('condition_id') == $condition->id)>
                                    {{ $condition->nama_kondisi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kategori --}}
                    <div class="filter-group">
                        <label for="category_id">
                            Kategori
                        </label>

                        <select name="category_id" id="category_id">
                            <option value="">
                                Semua Kategori
                            </option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="filter-actions">

                    <button type="submit" class="btn btn-primary">
                        Tampilkan Laporan
                    </button>

                    <a href="{{ route('laporan.stok') }}" class="btn btn-secondary">
                        Reset
                    </a>

                    <button type="button" class="btn btn-print" onclick="window.print()">
                        🖨️ Cetak Laporan
                    </button>

                </div>

            </form>

        </div>

        {{-- Tabel --}}
        <div class="table-card">

            <div class="table-header">
                <h2>Daftar Stok Aset</h2>
            </div>

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Aset</th>
                            <th>Nama Aset</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Kondisi</th>
                            <th class="text-right">Jumlah</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($stocks as $stock)
                            @php
                                $badgeClass = match ($stock->condition->nama_kondisi) {
                                    'Baik' => 'badge-baik',
                                    'Rusak Ringan' => 'badge-ringan',
                                    'Rusak Berat' => 'badge-berat',
                                    default => '',
                                };
                            @endphp

                            <tr>

                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $stock->asset->kode_aset }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $stock->asset->nama_aset }}
                                </td>

                                <td>
                                    {{ $stock->asset->category->nama_kategori }}
                                </td>

                                <td>
                                    {{ $stock->location->nama_lokasi }}
                                </td>

                                <td>
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $stock->condition->nama_kondisi }}
                                    </span>
                                </td>

                                <td class="text-right">
                                    {{ number_format($stock->jumlah, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ $stock->asset->satuan }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="empty">
                                    Belum ada stok aset.
                                </td>
                            </tr>
                        @endforelse

                        @if ($stocks->isNotEmpty())
                            <tr class="total-row">

                                <td colspan="6" class="text-right">
                                    TOTAL STOK AKTUAL
                                </td>

                                <td class="text-right">
                                    {{ number_format($totalStok, 0, ',', '.') }}
                                </td>

                                <td>
                                    Unit
                                </td>

                            </tr>
                        @endif

                    </tbody>

                </table>

            </div>

        </div>

        <div class="footer">
            Laporan dibuat pada {{ now()->translatedFormat('d F Y H:i') }}
        </div>

    </div>

</body>

</html>
