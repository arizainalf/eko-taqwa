<?php

namespace App\Filament\Widgets;

use App\Models\Ayat;
use App\Models\Chat;
use App\Models\Cp;
use App\Models\Device;
use App\Models\Fase;
use App\Models\Hadist;
use App\Models\HasilKuis;
use App\Models\JenisKaidah;
use App\Models\JenisTema;
use App\Models\Kaidah;
use App\Models\Kitab;
use App\Models\Kuis;
use App\Models\Mapel;
use App\Models\Pertanyaan;
use App\Models\Refleksi;
use App\Models\Tema;
use App\Models\Video;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DataOverviewWidget extends BaseWidget
{
    // Atur jumlah kolom maksimal
    protected function getColumns(): int | array | null
    {
        return 5; // Maksimal 5 kolom di layar besar
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Fase', Fase::count())->icon('heroicon-o-bookmark')->color('info'),
            Stat::make('Mapel', Mapel::count())->icon('heroicon-o-academic-cap')->color('success'),
            Stat::make('CP', Cp::count())->icon('heroicon-o-document-text')->color('primary'),
            Stat::make('Perangkat', Device::count())->icon('heroicon-o-device-phone-mobile')->color('warning'),
            Stat::make('Jenis Tema', JenisTema::count())->icon('heroicon-o-tag')->color('gray'),
            Stat::make('Tema', Tema::count())->icon('heroicon-o-squares-2x2')->color('indigo'),
            Stat::make('Ayat', Ayat::count())->icon('heroicon-o-clipboard-document-list')->color('emerald'),
            Stat::make('Hadist', Hadist::count())->icon('heroicon-o-chat-bubble-left-right')->color('amber'),
            Stat::make('Kaidah', Kaidah::count())->icon('heroicon-o-scale')->color('rose'),
            Stat::make('Jenis Kaidah', JenisKaidah::count())->icon('heroicon-o-rectangle-stack')->color('purple'),
            Stat::make('Kitab', Kitab::count())->icon('heroicon-o-book-open')->color('cyan'),
            Stat::make('Video', Video::count())->icon('heroicon-o-play-circle')->color('pink'),
            Stat::make('Kuis', Kuis::count())->icon('heroicon-o-clipboard-document-check')->color('lime'),
            Stat::make('Pertanyaan', Pertanyaan::count())->icon('heroicon-o-question-mark-circle')->color('orange'),
            Stat::make('Hasil Kuis', HasilKuis::count())->icon('heroicon-o-chart-bar')->color('teal'),
            Stat::make('Refleksi', Refleksi::count())->icon('heroicon-o-light-bulb')->color('fuchsia'),
            Stat::make('Chat', Chat::count())->icon('heroicon-o-chat-bubble-oval-left-ellipsis')->color('sky'),
        ];
    }
}
