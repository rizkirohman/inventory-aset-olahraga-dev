<?php

namespace App\Filament\Resources\ActivityLogs\Schemas;

use App\Models\ActivityLog;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Location;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class ActivityLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Aktivitas')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Waktu')
                            ->dateTime('d F Y H:i:s'),

                        TextEntry::make('user.name')
                            ->label('User')
                            ->placeholder('System'),

                        TextEntry::make('action')
                            ->label('Aktivitas')
                            ->badge()
                            ->formatStateUsing(
                                fn (string $state): string => match ($state) {
                                    'created' => 'Membuat',
                                    'updated' => 'Mengubah',
                                    'deleted' => 'Menghapus',
                                    'finalized' => 'Finalisasi',
                                    'login' => 'Login',
                                    'logout' => 'Logout',
                                    default => ucfirst($state),
                                }
                            ),

                        TextEntry::make('subject_type')
                            ->label('Jenis Data')
                            ->formatStateUsing(
                                fn (?string $state): string =>
                                    $state
                                        ? match (class_basename($state)) {
                                            'Asset' => 'Aset',
                                            'Category' => 'Kategori',
                                            'Condition' => 'Kondisi',
                                            'Location' => 'Lokasi',
                                            'AssetMutation' => 'Mutasi Aset',
                                            'Inventory' => 'Inventarisasi',
                                            'InventoryDetail' => 'Detail Inventarisasi',
                                            'User' => 'User',
                                            default => class_basename($state),
                                        }
                                        : '-'
                            ),

                        TextEntry::make('subject_id')
                            ->label('ID Data')
                            ->placeholder('-'),

                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),

                        TextEntry::make('ip_address')
                            ->label('IP Address')
                            ->placeholder('-'),

                        TextEntry::make('user_agent')
                            ->label('Browser / User Agent')
                            ->columnSpanFull()
                            ->limit(200),
                    ])
                    ->columns(2),

                Section::make('Perubahan Data')
                    ->schema([
                        TextEntry::make('change_details')
                            ->label('')
                            ->state(
                                fn (ActivityLog $record): HtmlString =>
                                    self::renderChanges($record)
                            )
                            ->html()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    protected static function renderChanges(ActivityLog $record): HtmlString
    {
        $oldValues = self::normalizeValues($record->old_values);
        $newValues = self::normalizeValues($record->new_values);

        /*
         * Gabungkan seluruh field yang terdapat pada
         * old_values dan new_values.
         */
        $keys = array_unique([
            ...array_keys($oldValues),
            ...array_keys($newValues),
        ]);

        /*
         * Untuk aktivitas UPDATE, tampilkan hanya field
         * yang benar-benar berubah.
         */
        if ($record->action === 'updated') {
            $keys = array_filter(
                $keys,
                fn (string $key): bool =>
                    ($oldValues[$key] ?? null) !== ($newValues[$key] ?? null)
            );
        }

        if (empty($keys)) {
            return new HtmlString(
                '<div style="padding: 14px; color: #6b7280;">
                    Tidak ada perubahan data.
                </div>'
            );
        }

        $html = '
            <div style="
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                overflow: hidden;
            ">
                <table style="
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 14px;
                ">
                    <thead>
                        <tr style="background: #f9fafb;">
                            <th style="
                                text-align: left;
                                padding: 12px;
                                border-bottom: 1px solid #e5e7eb;
                            ">
                                Field
                            </th>

                            <th style="
                                text-align: left;
                                padding: 12px;
                                border-bottom: 1px solid #e5e7eb;
                            ">
                                Sebelum
                            </th>

                            <th style="
                                text-align: left;
                                padding: 12px;
                                border-bottom: 1px solid #e5e7eb;
                            ">
                                Sesudah
                            </th>
                        </tr>
                    </thead>
                    <tbody>
        ';

        foreach ($keys as $key) {
            $old = $oldValues[$key] ?? null;
            $new = $newValues[$key] ?? null;

            $label = self::getFieldLabel($key);

            $oldDisplay = self::formatValue(
                $key,
                $old,
                $record
            );

            $newDisplay = self::formatValue(
                $key,
                $new,
                $record
            );

            $html .= '
                <tr>
                    <td style="
                        padding: 12px;
                        font-weight: 600;
                        background: #f9fafb;
                        border-bottom: 1px solid #e5e7eb;
                        width: 25%;
                    ">
                        ' . e($label) . '
                    </td>

                    <td style="
                        padding: 12px;
                        border-bottom: 1px solid #e5e7eb;
                        width: 37.5%;
                        word-break: break-word;
                    ">
                        ' . $oldDisplay . '
                    </td>

                    <td style="
                        padding: 12px;
                        border-bottom: 1px solid #e5e7eb;
                        width: 37.5%;
                        word-break: break-word;
                    ">
                        ' . $newDisplay . '
                    </td>
                </tr>
            ';
        }

        $html .= '
                    </tbody>
                </table>
            </div>
        ';

        return new HtmlString($html);
    }

    protected static function normalizeValues($values): array
    {
        if (is_string($values)) {
            $decoded = json_decode($values, true);

            return is_array($decoded) ? $decoded : [];
        }

        return is_array($values) ? $values : [];
    }

    protected static function getFieldLabel(string $key): string
    {
        return match ($key) {
            'name' => 'Nama',
            'email' => 'Email',
            'role' => 'Role',

            'kode_aset' => 'Kode Aset',
            'nama_aset' => 'Nama Aset',
            'category_id' => 'Kategori',
            'merek' => 'Merek',
            'tipe' => 'Tipe',
            'nomor_seri' => 'Nomor Seri',
            'tahun_perolehan' => 'Tahun Perolehan',
            'harga_perolehan' => 'Harga Perolehan',
            'sumber_dana' => 'Sumber Dana',
            'jumlah' => 'Jumlah',
            'satuan' => 'Satuan',
            'foto' => 'Foto',
            'keterangan' => 'Keterangan',

            'nama_kategori' => 'Nama Kategori',
            'nama_lokasi' => 'Nama Lokasi',
            'nama_kondisi' => 'Nama Kondisi',

            'asset_id' => 'Aset',
            'location_id' => 'Lokasi',
            'condition_id' => 'Kondisi',
            'lokasi_asal_id' => 'Lokasi Asal',
            'lokasi_tujuan_id' => 'Lokasi Tujuan',

            'jumlah_tercatat' => 'Jumlah Tercatat',
            'jumlah_ditemukan' => 'Jumlah Ditemukan',
            'selisih' => 'Selisih',

            'tanggal_mutasi' => 'Tanggal Mutasi',
            'alasan' => 'Alasan',

            'tanggal_inventarisasi' => 'Tanggal Inventarisasi',

            'status' => 'Status',

            default => str($key)->replace('_', ' ')->title(),
        };
    }

    protected static function formatValue(
        string $key,
        mixed $value,
        ActivityLog $record
    ): string {
        if (is_null($value)) {
            return '<span style="color: #9ca3af;">-</span>';
        }

        /*
         * Terjemahkan Foreign Key menjadi nama data.
         */
        $value = match ($key) {
            'asset_id' => self::resolveAsset($value),
            'category_id' => self::resolveCategory($value),
            'location_id',
            'lokasi_asal_id',
            'lokasi_tujuan_id' => self::resolveLocation($value),
            'condition_id' => self::resolveCondition($value),
            default => $value,
        };

        /*
         * Terjemahkan nilai role.
         */
        if ($key === 'role') {
            $value = match ($value) {
                'admin' => 'Admin',
                'petugas' => 'Petugas',
                default => $value,
            };
        }

        /*
         * Terjemahkan status.
         */
        if ($key === 'status') {
            $value = match ($value) {
                'draft' => 'Draft',
                'final' => 'Final',
                default => $value,
            };
        }

        /*
         * Format tanggal.
         */
        if (
            in_array($key, [
                'tanggal_mutasi',
                'tanggal_inventarisasi',
            ], true)
        ) {
            try {
                $value = \Carbon\Carbon::parse($value)
                    ->translatedFormat('d F Y');
            } catch (\Throwable) {
                // Gunakan nilai asli jika bukan tanggal valid.
            }
        }

        if (is_bool($value)) {
            $value = $value ? 'Ya' : 'Tidak';
        }

        if (is_array($value)) {
            $value = json_encode(
                $value,
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );
        }

        return e((string) $value);
    }

    protected static function resolveAsset($id): string
    {
        $asset = Asset::find($id);

        if (! $asset) {
            return "ID {$id}";
        }

        return "{$asset->kode_aset} - {$asset->nama_aset}";
    }

    protected static function resolveCategory($id): string
    {
        $category = Category::find($id);

        return $category
            ? $category->nama_kategori
            : "ID {$id}";
    }

    protected static function resolveLocation($id): string
    {
        $location = Location::find($id);

        return $location
            ? $location->nama_lokasi
            : "ID {$id}";
    }

    protected static function resolveCondition($id): string
    {
        $condition = Condition::find($id);

        return $condition
            ? $condition->nama_kondisi
            : "ID {$id}";
    }
}