<?php
namespace App\Filament\Resources\Mapels\Pages;

use App\Filament\Resources\Mapels\MapelResource;
use App\Models\Mapel;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;

class MassCreateMapel extends Page
{
    use InteractsWithSchemas;
    protected static string $resource = MapelResource::class;

    protected string $view = 'filament.resources.mapels.pages.mass-create-mapel';

    protected static ?string $title = 'Tambah Banyak Mata Pelajaran';

    public ?array $data = [];

    public function mount(): void
    {
        $this->schema->fill();
    }

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Mata Pelajaran')
                    ->icon(LucideIcon::Library)
                    ->schema([
                        Repeater::make('mapels')
                            ->schema([
                                TextInput::make('nama')
                                    ->required(),
                                Textarea::make('deskripsi')
                                    ->columnSpanFull(),
                            ])
                            ->hiddenLabel()
                            ->addActionLabel('Tambah Mata Pelajaran'),
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

    public function create(): void
    {
        $items = $this->schema->getState()['mapels'] ?? [];

        foreach ($items as $item) {
            Mapel::create([
                'nama'      => $item['nama'],
                'deskripsi' => $item['deskripsi'],
            ]);
        }

        Notification::make()
            ->title('Data berhasil dibuat secara massal')
            ->success()
            ->send();

        $this->redirect(MapelResource::getUrl('index'));
    }
}
