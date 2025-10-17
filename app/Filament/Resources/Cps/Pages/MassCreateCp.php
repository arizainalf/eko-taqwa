<?php
namespace App\Filament\Resources\Cps\Pages;

use App\Filament\Resources\Cps\CpResource;
use App\Models\Cp;
use App\Models\Fase;
use App\Models\Mapel;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;

class MassCreateCp extends Page
{
    use InteractsWithSchemas;
    protected static string $resource = CpResource::class;

    protected string $view = 'filament.resources.cps.pages.mass-create-cp';

    public ?array $data = [];

    public function mount(): void
    {
        $this->schema->fill();
    }

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Capaian Pembelajaran')
                    ->icon(LucideIcon::BookCheck)
                    ->schema([
                        Repeater::make('cps')
                            ->schema([
                                Select::make('fase_id')
                                    ->label('Fase')
                                    ->options(Fase::pluck('nama', 'id'))
                                    ->required(),
                                Select::make('mapel_id')
                                    ->label('Mapel')
                                    ->options(Mapel::pluck('nama', 'id'))
                                    ->required(),
                                Select::make('metode_pembelajaran')
                                    ->label('Metode Pembelajaran'
                                    )->options([
                                    'sekolah' => 'Di Sekolah',
                                    'rumah'   => 'Di Rumah'])
                                    ->default('sekolah')
                                    ->required(),
                                TextInput::make('nama')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Judul CP'),
                                Textarea::make('deskripsi')
                                    ->required()
                                    ->columnSpanFull(),
                                Textarea::make('pendekatan'),
                                Textarea::make('model'),
                                Textarea::make('teknik'),
                                Textarea::make('metode'),
                                Textarea::make('taktik'),
                            ])
                            ->columns(1)
                            ->addActionLabel('Tambah CP')
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
                ->label('Simpan')
                ->icon(LucideIcon::Save)
                ->button()
                ->color('success')
                ->action(fn() => $this->create()),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label('Simpan Semua')
                ->action('create'),
        ];
    }

    public function create(): void
    {
        $items = $this->schema->getState()['cps'] ?? [];

        foreach ($items as $item) {
            Cp::create([
                'fase_id'             => $item['fase_id'],
                'mapel_id'            => $item['mapel_id'],
                'metode_pembelajaran' => $item['metode_pembelajaran'],
                'nama'                => $item['nama'],
                'deskripsi'           => $item['deskripsi'],
                'pendekatan'          => $item['pendekatan'],
                'model'               => $item['model'],
                'teknik'              => $item['teknik'],
                'metode'              => $item['metode'],
                'taktik'              => $item['taktik'],
            ]);
        }

        Notification::make()
            ->title('Data berhasil dibuat secara massal')
            ->success()
            ->send();

        $this->redirect(CpResource::getUrl('index'));
    }
}
