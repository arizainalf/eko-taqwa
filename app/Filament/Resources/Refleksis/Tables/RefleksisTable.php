<?php
namespace App\Filament\Resources\Refleksis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Hugomyb\FilamentMediaAction\Actions\MediaAction;

class RefleksisTable
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
                TextColumn::make('device.name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('judul')
                    ->searchable(),
                TextColumn::make('deskripsi')
                    ->wrap()
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('tanggal')
                    ->date()
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
                MediaAction::make('lihat_media')
                    ->modalHeading(fn($record) => $record->judul)
                    ->icon('heroicon-o-photo')
                    ->media(fn($record) => asset('storage/' . $record->gambar))
                    ->mediaType('image')
                    ->hiddenLabel(),
                ViewAction::make(),
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
