<?php

namespace App\Filament\Resources\HasilKuis\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class HasilKuisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->getStateUsing(function ($record, $loop): string {
                        static $counter = 1;
                        $currentPage    = request('page', 1);
                        $perPage        = $loop->parent->perPage ?? 10;
                        return (string) (($currentPage - 1) * $perPage + $counter++);
                    }),
                TextColumn::make('device.nama')
                    ->searchable(),
                TextColumn::make('kuis.judul')
                    ->searchable(),
                TextColumn::make('skor')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_pertanyaan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jawaban_benar')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jawaban_salah')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('waktu_pengerjaan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // EditAction::make(),
                // DeleteAction::make(),
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
