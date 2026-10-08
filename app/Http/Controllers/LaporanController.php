<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Asset;
use App\Models\AssetMutation;
use App\Models\AssetStock;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function stok(Request $request)
    {
        $stocks = AssetStock::query()
            ->with([
                'asset.category',
                'location',
                'condition',
            ])
            ->where('jumlah', '>', 0)
            ->when(
                $request->filled('location_id'),
                fn ($query) => $query->where('location_id', $request->location_id)
            )
            ->when(
                $request->filled('condition_id'),
                fn ($query) => $query->where('condition_id', $request->condition_id)
            )
            ->when(
                $request->filled('category_id'),
                fn ($query) => $query->whereHas(
                    'asset',
                    fn ($query) => $query->where('category_id', $request->category_id)
                )
            )
            ->orderBy('location_id')
            ->orderBy('asset_id')
            ->get();

        $locations = Location::query()
            ->orderBy('nama_lokasi')
            ->get();

        $conditions = Condition::query()
            ->orderBy('id')
            ->get();

        $categories = Category::query()
            ->orderBy('nama_kategori')
            ->get();

        return view('laporan.stok', compact(
            'stocks',
            'locations',
            'conditions',
            'categories'
        ));
    }

    public function mutasi(Request $request)
    {
        $mutations = AssetMutation::query()
            ->with([
                'asset.category',
                'condition',
                'lokasiAsal',
                'lokasiTujuan',
            ])
            ->when(
                $request->filled('tanggal_mulai'),
                fn ($query) => $query->whereDate(
                    'tanggal_mutasi',
                    '>=',
                    $request->tanggal_mulai
                )
            )
            ->when(
                $request->filled('tanggal_akhir'),
                fn ($query) => $query->whereDate(
                    'tanggal_mutasi',
                    '<=',
                    $request->tanggal_akhir
                )
            )
            ->when(
                $request->filled('asset_id'),
                fn ($query) => $query->where(
                    'asset_id',
                    $request->asset_id
                )
            )
            ->when(
                $request->filled('lokasi_asal_id'),
                fn ($query) => $query->where(
                    'lokasi_asal_id',
                    $request->lokasi_asal_id
                )
            )
            ->when(
                $request->filled('lokasi_tujuan_id'),
                fn ($query) => $query->where(
                    'lokasi_tujuan_id',
                    $request->lokasi_tujuan_id
                )
            )
            ->when(
                $request->filled('condition_id'),
                fn ($query) => $query->where(
                    'condition_id',
                    $request->condition_id
                )
            )
            ->orderByDesc('tanggal_mutasi')
            ->orderByDesc('id')
            ->get();

        $assets = Asset::query()
            ->orderBy('nama_aset')
            ->get();

        $locations = Location::query()
            ->orderBy('nama_lokasi')
            ->get();

        $conditions = Condition::query()
            ->orderBy('id')
            ->get();

        return view('laporan.mutasi', compact(
            'mutations',
            'assets',
            'locations',
            'conditions'
        ));
    }

    public function inventarisasi(Request $request)
    {
        $inventories = Inventory::query()
            ->with([
                'location',
                'inventoryDetails.asset',
                'inventoryDetails.condition',
            ])
            ->when(
                $request->filled('tanggal_mulai'),
                fn ($query) => $query->whereDate(
                    'tanggal_inventarisasi',
                    '>=',
                    $request->tanggal_mulai
                )
            )
            ->when(
                $request->filled('tanggal_akhir'),
                fn ($query) => $query->whereDate(
                    'tanggal_inventarisasi',
                    '<=',
                    $request->tanggal_akhir
                )
            )
            ->when(
                $request->filled('location_id'),
                fn ($query) => $query->where(
                    'location_id',
                    $request->location_id
                )
            )
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where(
                    'status',
                    $request->status
                )
            )
            ->orderByDesc('tanggal_inventarisasi')
            ->orderByDesc('id')
            ->get();

        $locations = Location::query()
            ->orderBy('nama_lokasi')
            ->get();

        return view('laporan.inventarisasi', compact(
            'inventories',
            'locations'
        ));
    }

    public function aktivitas(Request $request)
    {
        abort_unless(auth()->user()?->isAdmin(), 403);

        $query = ActivityLog::query()
            ->with('user');

        // Filter User
        $query->when(
            $request->filled('user_id'),
            fn ($query) =>
                $query->where('user_id', $request->user_id)
        );

        // Filter Aktivitas
        $query->when(
            $request->filled('action'),
            fn ($query) =>
                $query->where('action', $request->action)
        );

        // Filter tanggal dari
        $query->when(
            $request->filled('from'),
            fn ($query) =>
                $query->whereDate('created_at', '>=', $request->from)
        );

        // Filter tanggal sampai
        $query->when(
            $request->filled('until'),
            fn ($query) =>
                $query->whereDate('created_at', '<=', $request->until)
        );

        /*
        * =========================
        * SUMMARY
        * =========================
        *
        * Summary dihitung dari seluruh
        * hasil filter, bukan dari halaman
        * pagination yang sedang dibuka.
        */
        $summary = [
            'total' => (clone $query)->count(),

            'created' => (clone $query)
                ->where('action', 'created')
                ->count(),

            'updated' => (clone $query)
                ->where('action', 'updated')
                ->count(),

            'deleted' => (clone $query)
                ->where('action', 'deleted')
                ->count(),

            'finalized' => (clone $query)
                ->where('action', 'finalized')
                ->count(),
        ];

        /*
        * =========================
        * DATA LAPORAN
        * =========================
        *
        * Pagination hanya diterapkan
        * pada data tabel.
        */
        $logs = $query
            ->latest()
            ->paginate(25)
            ->withQueryString();

        /*
        * =========================
        * DATA USER
        * =========================
        */
        $users = User::query()
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('laporan.aktivitas', compact(
            'logs',
            'users',
            'summary'
        ));
    }
}