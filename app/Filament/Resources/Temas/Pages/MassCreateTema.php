<?php
namespace App\Filament\Resources\Temas\Pages;

use App\Filament\Resources\Temas\TemaResource;
use App\Models\JenisTema;
use App\Models\Tema;
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

class MassCreateTema extends Page
{
    use InteractsWithSchemas;
    protected static string $resource = TemaResource::class;

    protected string $view = 'filament.resources.temas.pages.mass-create-tema';

    public ?array $data = [];

    public function mount(): void
    {
        $this->schema->fill();
    }

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tambah Tema Massal')
                    ->icon(LucideIcon::Palette)
                    ->schema([
                        Repeater::make('temas')
                            ->schema([
                                Select::make('jenis_tema_id')
                                    ->required()
                                    ->label('Jenis Tema')
                                    ->options(JenisTema::pluck('nama', 'id')),
                                TextInput::make('nama')
                                    ->label('Nama Tema')
                                    ->required(),
                                Textarea::make('deskripsi')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull()
                            ->hiddenLabel()
                            ->addActionLabel('Tambah Tema'),
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
                ->icon(LucideIcon::Save)
                ->color('success')
                ->action(fn() => $this->create()),
        ];
    }
    public function create(): void
    {
        $items = $this->schema->getState()['temas'] ?? [];

        foreach ($items as $item) {
            Tema::create([
                'jenis_tema_id' => $item['jenis_tema_id'],
                'nama'          => $item['nama'],
                'deskripsi'     => $item['deskripsi'],
            ]);

        }

        Notification::make()
            ->title('Data berhasil dibuat secara massal')
            ->success()
            ->send();

        $this->redirect(TemaResource::getUrl('index'));
    }
}
