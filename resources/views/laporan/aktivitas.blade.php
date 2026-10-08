<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Aktivitas</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #212529;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;

            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .header-content h1 {
            margin: 0 0 5px;
            font-size: 24px;
            font-weight: 700;
        }

        .header-content p {
            margin: 0;
            color: #6c757d;
            font-size: 14px;
        }

        .btn-dashboard {
            display: inline-block;
            background: #6c757d;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        .btn-dashboard:hover {
            background: #5c636a;
            color: #ffffff;
        }

        /* =========================
           SUMMARY
        ========================= */

        .summary {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .summary-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 18px;
        }

        .summary-card .label {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 8px;
        }

        .summary-card .value {
            font-size: 24px;
            font-weight: 700;
        }

        /* =========================
           FILTER
        ========================= */

        .filter {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }

        .filter-title {
            margin: 0 0 15px;
            font-size: 16px;
            font-weight: 700;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 13px;
        }

        .form-control {
            width: 100%;
            padding: 9px 10px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            background: #ffffff;
            font-size: 14px;
            color: #212529;
        }

        .form-control:focus {
            outline: none;
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15);
        }

        .filter-actions {
            margin-top: 15px;
            display: flex;
            gap: 8px;
        }

        .btn {
            display: inline-block;
            padding: 9px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-primary {
            background: #0d6efd;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #0b5ed7;
            color: #ffffff;
        }

        .btn-secondary {
            background: #6c757d;
            color: #ffffff;
        }

        .btn-secondary:hover {
            background: #5c636a;
            color: #ffffff;
        }

        .btn-success {
            background: #198754;
            color: #ffffff;
        }

        .btn-success:hover {
            background: #157347;
            color: #ffffff;
        }

        /* =========================
           TABLE
        ========================= */

        .table-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            overflow: hidden;
        }

        .table-header {
            padding: 18px;
            border-bottom: 1px solid #e9ecef;
        }

        .table-header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
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
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
            text-align: left;
            vertical-align: middle;
            font-size: 13px;
        }

        th {
            background: #f8f9fa;
            font-weight: 700;
            white-space: nowrap;
            color: #495057;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .text-center {
            text-align: center;
        }

        /* =========================
           BADGE
        ========================= */

        .badge {
            display: inline-block;
            padding: 4px 9px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-created {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-updated {
            background: #fff3cd;
            color: #664d03;
        }

        .badge-deleted {
            background: #f8d7da;
            color: #842029;
        }

        .badge-finalized {
            background: #cff4fc;
            color: #055160;
        }

        .badge-default {
            background: #e2e3e5;
            color: #41464b;
        }

        /* =========================
           PAGINATION
        ========================= */

        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 18px;
            border-top: 1px solid #e9ecef;
            gap: 15px;
        }

        .pagination-info {
            color: #6c757d;
            font-size: 13px;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .pagination a,
        .pagination span {
            min-width: 34px;
            height: 34px;
            padding: 0 10px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border: 1px solid #dee2e6;
            border-radius: 6px;

            text-decoration: none;
            font-size: 13px;
            color: #495057;
            background: #ffffff;
        }

        .pagination a:hover {
            background: #f8f9fa;
        }

        .pagination .active {
            background: #0d6efd;
            border-color: #0d6efd;
            color: #ffffff;
            font-weight: 600;
        }

        .pagination .disabled {
            color: #adb5bd;
            background: #f8f9fa;
            cursor: not-allowed;
        }

        /* =========================
           FOOTER
        ========================= */

        .generated {
            margin-top: 15px;
            font-size: 12px;
            color: #6c757d;
            text-align: right;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1100px) {
            .summary {
                grid-template-columns: repeat(3, 1fr);
            }

            .filter-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {
            body {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .summary {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .pagination-wrapper {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 450px) {
            .summary {
                grid-template-columns: 1fr;
            }
        }

        /* =========================
           PRINT
        ========================= */

        @media print {

            body {
                background: #ffffff;
                padding: 0;
            }

            .header {
                border: none;
                padding: 0 0 20px;
            }

            .btn-dashboard,
            .filter,
            .pagination-wrapper,
            .no-print {
                display: none !important;
            }

            .summary {
                grid-template-columns: repeat(5, 1fr);
            }

            .summary-card,
            .table-section {
                border: none;
            }

            .table-header {
                padding-left: 0;
                padding-right: 0;
            }

            th,
            td {
                padding: 7px;
                font-size: 11px;
            }

            .generated {
                margin-top: 10px;
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
                <h1>Laporan Aktivitas</h1>

                <p>
                    Laporan aktivitas pengguna pada sistem inventaris aset peralatan olahraga.
                </p>
            </div>

            <a href="{{ url('/admin') }}" class="btn-dashboard">
                🏠 Kembali ke Dashboard
            </a>

        </div>


        {{-- =========================
         SUMMARY
    ========================== --}}
        <div class="summary">

            <div class="summary-card">
                <div class="label">
                    Total Aktivitas
                </div>

                <div class="value">
                    {{ number_format($summary['total']) }}
                </div>
            </div>

            <div class="summary-card">
                <div class="label">
                    Membuat
                </div>

                <div class="value">
                    {{ number_format($summary['created']) }}
                </div>
            </div>

            <div class="summary-card">
                <div class="label">
                    Mengubah
                </div>

                <div class="value">
                    {{ number_format($summary['updated']) }}
                </div>
            </div>

            <div class="summary-card">
                <div class="label">
                    Menghapus
                </div>

                <div class="value">
                    {{ number_format($summary['deleted']) }}
                </div>
            </div>

            <div class="summary-card">
                <div class="label">
                    Finalisasi
                </div>

                <div class="value">
                    {{ number_format($summary['finalized']) }}
                </div>
            </div>

        </div>


        {{-- =========================
         FILTER
    ========================== --}}
        <div class="filter no-print">

            <div class="filter-title">
                Filter Laporan
            </div>

            <form method="GET" action="{{ route('laporan.aktivitas') }}">

                <div class="filter-grid">

                    {{-- User --}}
                    <div class="form-group">

                        <label for="user_id">
                            User
                        </label>

                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">
                                Semua User
                            </option>

                            @foreach ($users as $id => $name)
                                <option value="{{ $id }}" @selected(request('user_id') == $id)>
                                    {{ $name }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- Aktivitas --}}
                    <div class="form-group">

                        <label for="action">
                            Aktivitas
                        </label>

                        <select name="action" id="action" class="form-control">

                            <option value="">
                                Semua Aktivitas
                            </option>

                            <option value="created" @selected(request('action') === 'created')>
                                Membuat
                            </option>

                            <option value="updated" @selected(request('action') === 'updated')>
                                Mengubah
                            </option>

                            <option value="deleted" @selected(request('action') === 'deleted')>
                                Menghapus
                            </option>

                            <option value="finalized" @selected(request('action') === 'finalized')>
                                Finalisasi
                            </option>

                            <option value="login" @selected(request('action') === 'login')>
                                Login
                            </option>

                            <option value="logout" @selected(request('action') === 'logout')>
                                Logout
                            </option>

                        </select>

                    </div>


                    {{-- Dari --}}
                    <div class="form-group">

                        <label for="from">
                            Dari Tanggal
                        </label>

                        <input type="date" name="from" id="from" class="form-control"
                            value="{{ request('from') }}">

                    </div>


                    {{-- Sampai --}}
                    <div class="form-group">

                        <label for="until">
                            Sampai Tanggal
                        </label>

                        <input type="date" name="until" id="until" class="form-control"
                            value="{{ request('until') }}">

                    </div>

                </div>


                <div class="filter-actions">

                    <button type="submit" class="btn btn-primary">
                        Tampilkan Laporan
                    </button>

                    <a href="{{ route('laporan.aktivitas') }}" class="btn btn-secondary">
                        Reset
                    </a>

                    <button type="button" class="btn btn-success" onclick="window.print()">
                        🖨 Cetak Laporan
                    </button>

                </div>

            </form>

        </div>


        {{-- =========================
         TABLE
    ========================== --}}
        <div class="table-section">

            <div class="table-header">

                <h2>
                    Daftar Aktivitas
                </h2>

            </div>

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th class="text-center">
                                No.
                            </th>

                            <th>
                                Waktu
                            </th>

                            <th>
                                User
                            </th>

                            <th>
                                Aktivitas
                            </th>

                            <th>
                                Jenis Data
                            </th>

                            <th>
                                Deskripsi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($logs as $index => $log)
                            @php

                                $badgeClass = match ($log->action) {
                                    'created' => 'badge-created',

                                    'updated' => 'badge-updated',

                                    'deleted' => 'badge-deleted',

                                    'finalized' => 'badge-finalized',

                                    default => 'badge-default',
                                };

                                $actionLabel = match ($log->action) {
                                    'created' => 'Membuat',

                                    'updated' => 'Mengubah',

                                    'deleted' => 'Menghapus',

                                    'finalized' => 'Finalisasi',

                                    'login' => 'Login',

                                    'logout' => 'Logout',

                                    default => ucfirst($log->action),
                                };

                                $subjectLabel = $log->subject_type
                                    ? match (class_basename($log->subject_type)) {
                                        'Asset' => 'Aset',

                                        'Category' => 'Kategori',

                                        'Condition' => 'Kondisi',

                                        'Location' => 'Lokasi',

                                        'AssetMutation' => 'Mutasi Aset',

                                        'Inventory' => 'Inventarisasi',

                                        'InventoryDetail' => 'Detail Inventarisasi',

                                        'User' => 'User',

                                        default => class_basename($log->subject_type),
                                    }
                                    : '-';

                            @endphp


                            <tr>

                                <td class="text-center">
                                    {{ $logs->firstItem() + $index }}
                                </td>

                                <td>
                                    {{ $log->created_at?->format('d/m/Y H:i:s') }}
                                </td>

                                <td>
                                    {{ $log->user?->name ?? 'System' }}
                                </td>

                                <td>

                                    <span class="badge {{ $badgeClass }}">
                                        {{ $actionLabel }}
                                    </span>

                                </td>

                                <td>
                                    {{ $subjectLabel }}
                                </td>

                                <td>
                                    {{ $log->description }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center" style="padding: 30px;">
                                    Tidak ada aktivitas yang ditemukan.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =========================
             PAGINATION
        ========================== --}}
            @if ($logs->total() > 0)

                <div class="pagination-wrapper">

                    <div class="pagination-info">

                        Menampilkan
                        <strong>{{ $logs->firstItem() }}</strong>
                        sampai
                        <strong>{{ $logs->lastItem() }}</strong>
                        dari
                        <strong>{{ $logs->total() }}</strong>
                        aktivitas

                    </div>


                    @if ($logs->lastPage() > 1)

                        <div class="pagination">

                            {{-- Previous --}}
                            @if ($logs->onFirstPage())
                                <span class="disabled">
                                    ‹
                                </span>
                            @else
                                <a href="{{ $logs->previousPageUrl() }}" aria-label="Halaman sebelumnya">
                                    ‹
                                </a>
                            @endif


                            {{-- Page Numbers --}}
                            @php

                                $current = $logs->currentPage();

                                $last = $logs->lastPage();

                                $start = max(1, $current - 2);

                                $end = min($last, $current + 2);

                            @endphp


                            @if ($start > 1)

                                <a href="{{ $logs->url(1) }}">
                                    1
                                </a>

                                @if ($start > 2)
                                    <span class="disabled">
                                        …
                                    </span>
                                @endif

                            @endif


                            @for ($page = $start; $page <= $end; $page++)
                                @if ($page == $current)
                                    <span class="active">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $logs->url($page) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endfor


                            @if ($end < $last)

                                @if ($end < $last - 1)
                                    <span class="disabled">
                                        …
                                    </span>
                                @endif

                                <a href="{{ $logs->url($last) }}">
                                    {{ $last }}
                                </a>

                            @endif


                            {{-- Next --}}
                            @if ($logs->hasMorePages())
                                <a href="{{ $logs->nextPageUrl() }}" aria-label="Halaman berikutnya">
                                    ›
                                </a>
                            @else
                                <span class="disabled">
                                    ›
                                </span>
                            @endif

                        </div>

                    @endif

                </div>

            @endif

        </div>


        {{-- =========================
         FOOTER
    ========================== --}}
        <div class="generated">

            Laporan dibuat pada
            {{ now()->format('d F Y H:i') }}

        </div>

    </div>

</body>

</html>
