<?php
namespace App\Filament\Resources\Dalils\Pages;

use App\Filament\Resources\Dalils\DalilResource;
use App\Models\Dalil;
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

class MassCreateDalil extends Page
{
    use InteractsWithSchemas;
    protected static string $resource = DalilResource::class;

    protected string $view = 'filament.resources.dalils.pages.mass-create-dalil';

    public ?array $data = [];

    public function mount(): void
    {
        $this->schema->fill();
    }

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dalil Ayat atau Hadist')
                    ->icon(LucideIcon::BookText)
                    ->schema([
                        Repeater::make('dalils')
                            ->schema([
                                Select::make('tema_id')
                                    ->required()
                                    ->label('Tema')
                                    ->options(Tema::pluck('nama', 'id')),
                                Select::make('jenis')
                                    ->options(['ayat' => 'Ayat', 'hadist' => 'Hadist'])
                                    ->required(),
                                Textarea::make('teks_asli')
                                    ->label('Teks Dalil')
                                    ->required()
                                    ->columnSpanFull(),
                                Textarea::make('terjemahan')
                                    ->required()
                                    ->columnSpanFull(),
                                Textarea::make('sumber')
                                    ->placeholder('QS. Al-A’raf: 31 / HR. Ibnu Majah')
                                    ->columnSpanFull(),
                                Textarea::make('penjelasan')
                                    ->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->addActionLabel('Tambah Dalil')
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
                ->label('Simpan Semua')
                ->action('create'),
        ];
    }

    public function create(): void
    {
        $items = $this->schema->getState()['dalils'] ?? [];

        foreach ($items as $item) {
            Dalil::create([
                'tema_id'    => $item['tema_id'],
                'jenis'      => $item['jenis'],
                'teks_asli'  => $item['teks_asli'],
                'terjemahan' => $item['terjemahan'],
                'sumber'     => $item['sumber'],
                'penjelasan' => $item['penjelasan'],

            ]);
        }

        Notification::make()
            ->title('Data berhasil dibuat secara massal')
            ->success()
            ->send();

        $this->redirect(DalilResource::getUrl('index'));
    }
}
