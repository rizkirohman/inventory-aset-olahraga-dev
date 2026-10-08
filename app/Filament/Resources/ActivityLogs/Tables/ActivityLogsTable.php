<?php

namespace App\Filament\Resources\ActivityLogs\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->placeholder('System'),

                TextColumn::make('action')
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
                    )
                    ->colors([
                        'success' => 'created',
                        'warning' => 'updated',
                        'danger' => 'deleted',
                        'info' => 'finalized',
                    ])
                    ->sortable(),

                TextColumn::make('subject_type')
                    ->label('Jenis Data')
                    ->formatStateUsing(
                        fn (?string $state): string =>
                            $state
                                ? class_basename($state)
                                : '-'
                    )
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('user_agent')
                    ->label('Browser / User Agent')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('user_id')
                    ->label('User')
                    ->options(
                        User::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                    ),

                SelectFilter::make('action')
                    ->label('Aktivitas')
                    ->options([
                        'created' => 'Membuat',
                        'updated' => 'Mengubah',
                        'deleted' => 'Menghapus',
                        'finalized' => 'Finalisasi',
                        'login' => 'Login',
                        'logout' => 'Logout',
                    ]),

                Filter::make('created_at')
                    ->label('Rentang Tanggal')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')
                            ->label('Dari'),

                        \Filament\Forms\Components\DatePicker::make('until')
                            ->label('Sampai'),
                    ])
                    ->query(
                        fn (
                            Builder $query,
                            array $data
                        ): Builder => $query
                            ->when(
                                $data['from'] ?? null,
                                fn (Builder $query, $date): Builder =>
                                    $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['until'] ?? null,
                                fn (Builder $query, $date): Builder =>
                                    $query->whereDate('created_at', '<=', $date)
                            )
                    ),
            ])

            ->recordActions([
                ViewAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([]),
            ])

            ->defaultSort('created_at', 'desc');
    }
}