<?php
namespace App\Filament\Resources\JenisTemas\Pages;

use App\Filament\Resources\JenisTemas\JenisTemaResource;
use App\Models\JenisTema;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;

class CreateBulk extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string $resource = JenisTemaResource::class;

    protected string $view = 'filament.resources.jenis-temas.pages.create-bulk';

    public ?array $data = [];

    public function mount(): void
    {
        $this->schema->fill();
    }

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Jenis Tema')
                    ->icon(LucideIcon::SquareLibrary)
                    ->schema([
                        Repeater::make('items')
                            ->schema([
                                TextInput::make('nama')
                                    ->required(),
                                Textarea::make('deskripsi')
                                    ->columnSpanFull(),
                            ])
                            ->addActionLabel('Tambah Jenis Tema')
                            ->collapsible()
                            ->defaultItems(1)
                            ->columnSpanFull(),
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
                ->label('Simpan Semua')
                ->action('create'),
        ];
    }

    public function create(): void
    {
        $items = $this->schema->getState()['items'] ?? [];

        foreach ($items as $item) {
            JenisTema::create([
                'nama'      => $item['nama'],
                'deskripsi' => $item['deskripsi'] ?? null,
            ]);
        }

        Notification::make()
            ->title('Data berhasil dibuat secara massal')
            ->success()
            ->send();

        $this->redirect(JenisTemaResource::getUrl('index'));
    }
}
