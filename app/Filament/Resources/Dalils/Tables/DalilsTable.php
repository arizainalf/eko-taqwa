<?php
namespace App\Filament\Resources\Dalils\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DalilsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("no")
                    ->label('No')
                    ->getStateUsing(function ($record, $loop): string {
                        static $counter = 1;
                        $currentPage    = request('page', 1);
                        $perPage        = $loop->parent->perPage ?? 10;
                        return (string) (($currentPage - 1) * $perPage + $counter++);
                    }),
                TextColumn::make('tema.nama')
                    ->searchable(),
                TextColumn::make('jenis')
                    ->label('Jenis Dalil')
                    ->description('Ayat / Hadist')
                    ->searchable(true),
                TextColumn::make('teks_asli')
                    ->label('Ayat / Hadist')
                    ->limit(50)
                    ->searchable(true),
                TextColumn::make('terjemahan')
                    ->label('Terjemahan')
                    ->limit(50)
                    ->searchable(true),
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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
