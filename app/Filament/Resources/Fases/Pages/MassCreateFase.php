<?php
namespace App\Filament\Resources\Fases\Pages;

use App\Filament\Resources\Fases\FaseResource;
use App\Models\Fase;
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

class MassCreateFase extends Page
{
    use InteractsWithSchemas;
    protected static string $resource = FaseResource::class;

    protected string $view = 'filament.resources.fases.pages.mass-create-fase';

    protected static ?string $title = 'Tambah Banyak Fase';

    public ?array $data = [];

    public function mount(): void
    {
        $this->schema->fill();
    }

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Fase')
                    ->icon(LucideIcon::Library)
                    ->schema([
                        Repeater::make('fases')
                            ->schema([
                                TextInput::make('nama')
                                    ->required(),
                                Textarea::make('deskripsi')
                                    ->columnSpanFull(),
                            ])
                            ->hiddenLabel()
                            ->addActionLabel('Tambah Fase'),
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
        $items = $this->schema->getState()['fases'] ?? [];

        foreach ($items as $item) {
            Fase::create([
                'nama'      => $item['nama'],
                'deskripsi' => $item['deskripsi'],
            ]);
        }

        Notification::make()
            ->title('Data berhasil dibuat secara massal')
            ->success()
            ->send();

        $this->redirect(FaseResource::getUrl('index'));
    }
}
