<?php
namespace App\Filament\Resources\Pertanyaans\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OpsipertanyaanRelationManager extends RelationManager
{
    protected static string $relationship = 'opsipertanyaan';

    protected static ?string $title = 'Opsi Pertanyaan';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pertanyaan')->schema([
                    Textarea::make('jawaban')
                        ->label('Jawaban')
                        ->required()
                        ->maxLength(255),
                    Toggle::make('benar')
                        ->label('Benar ?')
                        ->inline(false),
                ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('jawaban')
            ->columns([
                TextColumn::make('no_urut')
                    ->label('No')
                    ->getStateUsing(function ($record, $loop): string {
                        static $counter = 1;
                        $currentPage    = request('page', 1);
                        $perPage        = $loop->parent->perPage ?? 10;
                        return (string) (($currentPage - 1) * $perPage + $counter++);
                    }),
                TextColumn::make('jawaban')
                    ->searchable(),
                TextColumn::make('benar')
                    ->label('Benar')
                    ->formatStateUsing(fn($state) => $state ? 'Ya' : 'Tidak'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->icon('heroicon-o-plus')
                    ->label('Tambah Jawaban'),
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
