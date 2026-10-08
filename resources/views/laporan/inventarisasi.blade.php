<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Inventarisasi Aset</title>

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
            max-width: 1500px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        /* Tambahkan style ini untuk header flex */
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

        /* =========================
           FILTER
        ========================= */

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

        .filter-group input,
        .filter-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            background: #ffffff;
            font-size: 14px;
            color: #212529;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            outline: none;
            border-color: #86b7fe;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-primary {
            background: #0d6efd;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #0b5ed7;
        }

        .btn-secondary {
            background: #6c757d;
            color: #ffffff;
        }

        .btn-secondary:hover {
            background: #5c636a;
        }

        .btn-print {
            background: #198754;
            color: #ffffff;
        }

        .btn-print:hover {
            background: #157347;
        }

        /* =========================
           SUMMARY
        ========================= */

        .summary {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
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
            font-size: 13px;
            margin-bottom: 8px;
        }

        .summary-card .value {
            font-size: 26px;
            font-weight: bold;
        }

        /* =========================
           TABLE
        ========================= */

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

        /* =========================
           BADGE
        ========================= */

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-final {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-draft {
            background: #fff3cd;
            color: #664d03;
        }

        .badge-sesuai {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-kurang {
            background: #f8d7da;
            color: #842029;
        }

        .badge-lebih {
            background: #cff4fc;
            color: #055160;
        }

        .badge-netral {
            background: #e9ecef;
            color: #495057;
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

        /* =========================
           FOOTER
        ========================= */

        .footer {
            margin-top: 20px;
            color: #6c757d;
            font-size: 13px;
            text-align: right;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1100px) {

            .summary {
                grid-template-columns: repeat(3, 1fr);
            }

        }

        @media (max-width: 768px) {

            .container {
                margin: 20px auto;
                padding: 0 12px;
            }

            .header h1 {
                font-size: 23px;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .summary {
                grid-template-columns: 1fr;
            }

            .filter-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

        }

        /* =========================
           PRINT
        ========================= */

        @media print {

            body {
                background: #ffffff;
            }

            .print-hidden {
                display: none !important;
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
                grid-template-columns: repeat(5, 1fr);
            }

            .table-card {
                border-radius: 0;
            }

            .table-wrapper {
                overflow: visible;
            }

            table {
                width: 100%;
            }

            th,
            td {
                padding: 8px 10px;
                font-size: 10px;
            }

            .footer {
                font-size: 10px;
            }

        }
    </style>
</head>

<body>

    <div class="container">

        {{-- =========================
         HEADER
    ========================== --}}

        <div class="header">

            <div class="header-content">
                <div>
                    <h1>
                        Laporan Inventarisasi Aset
                    </h1>

                    <p>
                        Laporan hasil inventarisasi atau Stock Opname aset berdasarkan lokasi dan kondisi.
                    </p>
                </div>

                <a href="{{ url('/admin') }}" class="btn btn-secondary print-hidden" style="text-decoration: none;">
                    🏠 Kembali ke Dashboard
                </a>
            </div>

        </div>


        {{-- =========================
         FILTER
    ========================== --}}

        <div class="filter-card print-hidden">

            <div class="filter-header">

                <h2>
                    Filter Laporan
                </h2>

            </div>


            <form method="GET" action="{{ route('laporan.inventarisasi') }}">

                <div class="filter-grid">

                    {{-- Tanggal Mulai --}}
                    <div class="filter-group">

                        <label for="tanggal_mulai">
                            Tanggal Mulai
                        </label>

                        <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                            value="{{ request('tanggal_mulai') }}">

                    </div>


                    {{-- Tanggal Akhir --}}
                    <div class="filter-group">

                        <label for="tanggal_akhir">
                            Tanggal Akhir
                        </label>

                        <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                            value="{{ request('tanggal_akhir') }}">

                    </div>


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


                    {{-- Status --}}
                    <div class="filter-group">

                        <label for="status">
                            Status
                        </label>

                        <select name="status" id="status">

                            <option value="">
                                Semua Status
                            </option>

                            <option value="draft" @selected(request('status') === 'draft')>
                                Draft
                            </option>

                            <option value="final" @selected(request('status') === 'final')>
                                Final
                            </option>

                        </select>

                    </div>

                </div>


                {{-- Tombol --}}
                <div class="filter-actions">

                    <button type="submit" class="btn btn-primary">
                        Tampilkan Laporan
                    </button>


                    <a href="{{ route('laporan.inventarisasi') }}" class="btn btn-secondary">
                        Reset
                    </a>


                    <button type="button" class="btn btn-print" onclick="window.print()">
                        🖨️ Cetak Laporan
                    </button>

                </div>

            </form>

        </div>


        {{-- =========================
         RINGKASAN
    ========================== --}}

        @php

            $totalInventarisasi = $inventories->count();

            $totalJenisAset = $inventories
                ->flatMap(fn($inventory) => $inventory->inventoryDetails)
                ->pluck('asset_id')
                ->unique()
                ->count();

            $totalTercatat = $inventories
                ->flatMap(fn($inventory) => $inventory->inventoryDetails)
                ->sum('jumlah_tercatat');

            $totalDitemukan = $inventories
                ->flatMap(fn($inventory) => $inventory->inventoryDetails)
                ->sum('jumlah_ditemukan');

            $totalSelisih = $inventories->flatMap(fn($inventory) => $inventory->inventoryDetails)->sum('selisih');

        @endphp


        <div class="summary">

            {{-- Total Inventarisasi --}}
            <div class="summary-card">

                <div class="label">
                    Total Inventarisasi
                </div>

                <div class="value">
                    {{ $totalInventarisasi }}
                </div>

            </div>


            {{-- Total Jenis Aset --}}
            <div class="summary-card">

                <div class="label">
                    Total Jenis Aset
                </div>

                <div class="value">
                    {{ $totalJenisAset }}
                </div>

            </div>


            {{-- Total Tercatat --}}
            <div class="summary-card">

                <div class="label">
                    Total Tercatat
                </div>

                <div class="value">
                    {{ number_format($totalTercatat, 0, ',', '.') }}
                </div>

            </div>


            {{-- Total Ditemukan --}}
            <div class="summary-card">

                <div class="label">
                    Total Ditemukan
                </div>

                <div class="value">
                    {{ number_format($totalDitemukan, 0, ',', '.') }}
                </div>

            </div>


            {{-- Total Selisih --}}
            <div class="summary-card">

                <div class="label">
                    Total Selisih
                </div>

                <div class="value">
                    {{ number_format($totalSelisih, 0, ',', '.') }}
                </div>

            </div>

        </div>


        {{-- =========================
         TABEL
    ========================== --}}

        <div class="table-card">

            <div class="table-header">

                <h2>
                    Detail Hasil Inventarisasi
                </h2>

            </div>


            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th class="text-center">No.</th>

                            <th>Tanggal</th>

                            <th>Lokasi</th>

                            <th>Status</th>

                            <th>Kode Aset</th>

                            <th>Nama Aset</th>

                            <th>Kondisi</th>

                            <th class="text-right">
                                Tercatat
                            </th>

                            <th class="text-right">
                                Ditemukan
                            </th>

                            <th class="text-right">
                                Selisih
                            </th>

                            <th>Keterangan</th>

                        </tr>

                    </thead>


                    <tbody>

                        @php
                            $nomor = 1;
                        @endphp


                        @forelse ($inventories as $inventory)

                            @foreach ($inventory->inventoryDetails as $detail)
                                @php

                                    $selisih = (int) $detail->selisih;

                                    $statusClass = match ($inventory->status) {
                                        'final' => 'badge-final',

                                        'draft' => 'badge-draft',

                                        default => 'badge-netral',
                                    };

                                    if ($selisih === 0) {
                                        $selisihClass = 'badge-sesuai';
                                        $selisihLabel = 'Sesuai';
                                    } elseif ($selisih < 0) {
                                        $selisihClass = 'badge-kurang';
                                        $selisihLabel = 'Kurang';
                                    } else {
                                        $selisihClass = 'badge-lebih';
                                        $selisihLabel = 'Lebih';
                                    }

                                @endphp


                                <tr>

                                    <td class="text-center">
                                        {{ $nomor++ }}
                                    </td>


                                    <td>
                                        {{ $inventory->tanggal_inventarisasi->format('d/m/Y') }}
                                    </td>


                                    <td>
                                        {{ $inventory->location->nama_lokasi }}
                                    </td>


                                    <td>

                                        <span class="badge {{ $statusClass }}">

                                            {{ ucfirst($inventory->status) }}

                                        </span>

                                    </td>


                                    <td>

                                        <strong>
                                            {{ $detail->asset->kode_aset }}
                                        </strong>

                                    </td>


                                    <td>
                                        {{ $detail->asset->nama_aset }}
                                    </td>


                                    <td>
                                        {{ $detail->condition->nama_kondisi }}
                                    </td>


                                    <td class="text-right">

                                        {{ number_format($detail->jumlah_tercatat, 0, ',', '.') }}

                                    </td>


                                    <td class="text-right">

                                        {{ number_format($detail->jumlah_ditemukan, 0, ',', '.') }}

                                    </td>


                                    <td class="text-right">

                                        <span class="badge {{ $selisihClass }}">

                                            {{ $selisih > 0 ? '+' : '' }}{{ $selisih }}

                                            -
                                            {{ $selisihLabel }}

                                        </span>

                                    </td>


                                    <td>

                                        {{ $detail->keterangan ?? '-' }}

                                    </td>

                                </tr>
                            @endforeach


                        @empty

                            <tr>

                                <td colspan="11" class="empty">
                                    Belum ada data inventarisasi.
                                </td>

                            </tr>

                        @endforelse


                        {{-- Total --}}
                        @if ($inventories->isNotEmpty())
                            <tr class="total-row">

                                <td colspan="7" class="text-right">
                                    TOTAL
                                </td>


                                <td class="text-right">

                                    {{ number_format($totalTercatat, 0, ',', '.') }}

                                </td>


                                <td class="text-right">

                                    {{ number_format($totalDitemukan, 0, ',', '.') }}

                                </td>


                                <td class="text-right">

                                    {{ $totalSelisih > 0 ? '+' : '' }}{{ number_format($totalSelisih, 0, ',', '.') }}

                                </td>


                                <td></td>

                            </tr>
                        @endif

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =========================
         FOOTER
    ========================== --}}

        <div class="footer">

            Laporan dibuat pada
            {{ now()->translatedFormat('d F Y H:i') }}

        </div>

    </div>

</body>

</html>
