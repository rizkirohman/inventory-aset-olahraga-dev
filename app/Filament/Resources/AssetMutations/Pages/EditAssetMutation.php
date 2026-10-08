<?php

namespace App\Filament\Resources\AssetMutations\Pages;

use App\Filament\Resources\AssetMutations\AssetMutationResource;
use Filament\Resources\Pages\EditRecord;

class EditAssetMutation extends EditRecord
{
    protected static string $resource = AssetMutationResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);

        $this->redirect(
            AssetMutationResource::getUrl('view', [
                'record' => $this->record,
            ])
        );
    }
}