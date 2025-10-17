<?php
namespace App\Filament\Resources\Pertanyaans\Pages;

use App\Filament\Resources\Pertanyaans\PertanyaanResource;
use App\Models\Kuis;
use App\Models\OpsiPertanyaan;
use App\Models\Pertanyaan;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MassCreatePertanyaan extends Page
{
    protected static string $resource = PertanyaanResource::class;

    protected string $view = 'filament.resources.pertanyaans.pages.mass-create-pertanyaan';

    public ?array $data = [];

    public function mount(): void
    {
        $this->schema->fill();
    }

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pertanyaan')
                    ->icon(LucideIcon::CircleQuestionMark)
                    ->schema([
                        Repeater::make('pertanyaans')
                            ->label('Pertanyaan')
                            ->schema([
                                Select::make('kuis_id')
                                    ->label('Kuis')
                                    ->options(Kuis::pluck('judul', 'id'))
                                    ->required(),
                                Textarea::make('teks_pertanyaan')
                                    ->required()
                                    ->columnSpanFull(),
                                Repeater::make('jawabans')
                                    ->label('Jawaban')
                                    ->schema([
                                        Grid::make(1)->schema([
                                            Textarea::make('jawaban')
                                                ->label('Jawaban')
                                                ->required()
                                                ->maxLength(255),
                                            Toggle::make('benar')
                                                ->label('Benar ?')
                                                ->inline(false),
                                        ]),
                                    ])
                                    ->columns(1)
                                    ->addActionLabel('Tambah Jawaban')
                                    ->collapsible() // Agar bisa diciutkan
                                    ->defaultItems(1),
                            ]),
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
        $items = $this->schema->getState()['pertanyaans'] ?? [];

        foreach ($items as $item) {
            $pertanyaan = Pertanyaan::create([
                'kuis_id'         => $item['kuis_id'],
                'teks_pertanyaan' => $item['teks_pertanyaan'],
            ]);

            foreach ($item['jawabans'] as $item2) {
                OpsiPertanyaan::create([
                    'pertanyaan_id' => $pertanyaan->id,
                    'jawaban'       => $item2['jawaban'],
                    'benar'         => $item2['benar'] ?? false,
                ]);
            }

        }

        Notification::make()
            ->title('Data berhasil dibuat secara massal')
            ->success()
            ->send();

        $this->redirect(url()->previous());
    }
}
