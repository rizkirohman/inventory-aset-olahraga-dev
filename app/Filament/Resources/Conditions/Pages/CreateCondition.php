<?php

namespace App\Filament\Resources\Conditions\Pages;

use App\Filament\Resources\Conditions\ConditionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCondition extends CreateRecord
{
    protected static string $resource = ConditionResource::class;

    // Mengarahkan kembali ke halaman tabel (index/list) setelah simpan
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
