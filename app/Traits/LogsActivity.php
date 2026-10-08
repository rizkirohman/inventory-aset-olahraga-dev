<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            $model->createActivityLog('created');
        });

        static::updated(function (Model $model) {
            /*
            * Laravel dapat mengubah remember_token
            * ketika proses autentikasi.
            *
            * Jika hanya remember_token yang berubah,
            * jangan dicatat sebagai aktivitas "updated".
            */
            if (
                $model->isDirty('remember_token')
                && count($model->getDirty()) === 1
            ) {
                return;
            }

            $model->createActivityLog('updated');
        });

        static::deleted(function (Model $model) {
            $model->createActivityLog('deleted');
        });
    }

    protected function createActivityLog(string $action): void
    {
        $description = $this->getActivityDescription($action);

        $oldValues = $action === 'updated' || $action === 'deleted'
            ? $this->getOriginal()
            : null;

        $newValues = $action === 'created' || $action === 'updated'
            ? $this->getAttributes()
            : null;

        /*
         * Jangan pernah menyimpan data sensitif
         * ke dalam Activity Log.
         */
        $oldValues = $this->sanitizeActivityValues($oldValues);
        $newValues = $this->sanitizeActivityValues($newValues);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'subject_type' => $this::class,
            'subject_id' => $this->getKey(),
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    protected function sanitizeActivityValues(?array $values): ?array
    {
        if ($values === null) {
            return null;
        }

        return collect($values)
            ->except([
                'password',
                'remember_token',
            ])
            ->toArray();
    }

    protected function getActivityDescription(string $action): string
    {
        $identifier = $this->getActivityIdentifier();

        return match ($action) {
            'created' => "Membuat {$identifier}",
            'updated' => "Mengubah {$identifier}",
            'deleted' => "Menghapus {$identifier}",
            'finalized' => "Finalisasi {$identifier}",
            default => ucfirst($action) . " {$identifier}",
        };
    }

    protected function getActivityIdentifier(): string
    {
        if ($this->getAttribute('kode_aset')) {
            return 'Asset ' . $this->getAttribute('kode_aset');
        }

        if ($this->getAttribute('nama_aset')) {
            return 'Asset ' . $this->getAttribute('nama_aset');
        }

        if ($this->getAttribute('nama_kategori')) {
            return 'Kategori ' . $this->getAttribute('nama_kategori');
        }

        if ($this->getAttribute('nama_lokasi')) {
            return 'Lokasi ' . $this->getAttribute('nama_lokasi');
        }

        if ($this->getAttribute('nama_kondisi')) {
            return 'Kondisi ' . $this->getAttribute('nama_kondisi');
        }

        if ($this->getAttribute('name')) {
            return 'User ' . $this->getAttribute('name');
        }

        if ($this->getKey()) {
            return class_basename($this) . ' #' . $this->getKey();
        }

        return class_basename($this);
    }
}