<?php

namespace App\Filament\Resources\Conditions\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ConditionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_kondisi')
                    ->label('Nama Kondisi')
                    ->required()
                    ->maxLength(255),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(4),
            ]);
    }
}