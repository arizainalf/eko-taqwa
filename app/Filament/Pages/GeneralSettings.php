<?php
namespace App\Filament\Pages;

use App\Settings\GeneralSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class GeneralSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings = GeneralSetting::class;

    protected static ?string $navigationLabel = 'Pengaturan Umum';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan')
                ->action(fn() => $this->save())
                ->color('primary'),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Umum')
                    ->description('Atur nama, email, dan logo aplikasi.')
                    ->icon('heroicon-o-information-circle')
                    ->columns(2)
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Nama Aplikasi')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('email')
                            ->email()
                            ->label('Email Admin')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        FileUpload::make('logo_path')
                            ->label('Upload Logo Aplikasi')
                            ->directory('logos')
                            ->disk('public')
                            ->visibility('public')
                            ->image()
                            ->maxSize(1024)
                            ->nullable(),
                    ]),

                Section::make('Mode Pemeliharaan')
                    ->description('Aktifkan untuk menampilkan halaman maintenance.')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->schema([
                        Toggle::make('maintenance_mode')
                            ->label('Aktifkan Maintenance Mode'),
                    ]),
            ]);
    }

    public function getFormActions(): array
    {
        return [];
    }

}
