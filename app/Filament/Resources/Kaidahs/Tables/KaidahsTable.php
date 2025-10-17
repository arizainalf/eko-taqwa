<?php
namespace App\Filament\Resources\Kaidahs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KaidahsTable
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
                TextColumn::make('tema.nama')
                    ->searchable(),
                TextColumn::make('jenis_kaidah')
                    ->label('Jenis Kaidah')
                    ->searchable()
                    ->formatStateUsing(fn($state) => 'Kaidah ' . ucfirst($state)),
                TextColumn::make('kaidah')
                    ->wrap(),
                TextColumn::make('kaidah_latin')
                    ->wrap(),
                TextColumn::make('terjemahan')
                    ->wrap(),
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
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
