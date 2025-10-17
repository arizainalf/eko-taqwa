<?php
namespace App\Filament\Resources\Kaidahs\Pages;

use App\Filament\Resources\Kaidahs\KaidahResource;
use App\Models\Kaidah;
use App\Models\Tema;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;

class MassCreateKaidah extends Page
{
    use InteractsWithSchemas;
    protected static string $resource = KaidahResource::class;

    protected string $view = 'filament.resources.kaidahs.pages.mass-create-kaidah';

    public ?array $data = [];

    public function mount(): void
    {
        $this->schema->fill();
    }

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kaidah')
                    ->icon(LucideIcon::Scale)
                    ->schema([
                        Repeater::make('kaidahs')
                            ->schema([
                                Select::make('tema_id')
                                    ->required()
                                    ->label('Tema')
                                    ->options(Tema::pluck('nama', 'id')),
                                Select::make('jenis_kaidah')
                                    ->options(['ushuliyah' => 'Kaidah Ushuliyah', 'fiqhiyah' => 'Kaidah Fiqhiyah'])
                                    ->required(),
                                Textarea::make('kaidah')
                                    ->required()
                                    ->columnSpanFull(),
                                Textarea::make('kaidah_latin')
                                    ->nullable()
                                    ->columnSpanFull(),
                                Textarea::make('terjemahan')
                                    ->nullable()
                                    ->columnSpanFull(),
                                Textarea::make('deskripsi')
                                    ->nullable()
                                    ->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->addActionLabel('Tambah Kaidah')
                            ->collapsible() // Agar bisa diciutkan
                            ->defaultItems(1),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    protected function getActions(): array
    {
        return [
            Action::make('create')
                ->label('Simpan Semua')
                ->button()
                ->color('success')
                ->action(fn() => $this->create()),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->icon(LucideIcon::Save)
                ->label('Simpan')
                ->action('create'),
        ];
    }

    public function create(): void
    {
        $items = $this->schema->getState()['kaidahs'] ?? [];

        foreach ($items as $item) {
            Kaidah::create([
                'tema_id'      => $item['tema_id'],
                'jenis_kaidah' => $item['jenis_kaidah'],
                'kaidah'       => $item['kaidah'],
                'kaidah_latin' => $item['kaidah_latin'],
                'terjemahan'   => $item['terjemahan'],
                'deskripsi'    => $item['deskripsi'],
            ]);
        }

        Notification::make()
            ->title('Data berhasil dibuat secara massal')
            ->success()
            ->send();

        $this->redirect(KaidahResource::getUrl('index'));
    }
}
