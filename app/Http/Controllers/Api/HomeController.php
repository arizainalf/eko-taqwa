<?php
// app/Http/Controllers/Api/HomeController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cp;
use App\Models\Device;
use App\Models\Kaidah;
use App\Models\Kuis;
use App\Models\Refleksi;
use App\Models\Tema;
use App\Models\Video;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use ApiResponder;
    public function index(Request $request)
    {
        $deviceId = $request->header('Device-ID');

        // Get device data
        $device = Device::where('id', $deviceId)->first();

        // Get stats for dashboard
        $stats = [
            'total_tema'     => Tema::count(),
            'total_kuis'     => Kuis::where('aktif', true)->count(),
            'total_video'    => Video::count(),
            'total_cp'       => Cp::count(),
            'total_kaidah'   => Kaidah::count(),
            'total_refleksi' => Refleksi::count(),
            'total_ayat'      => \App\Models\Ayat::count(),
            'total_hadist'   => \App\Models\Hadist::count(),
            'total_kitab'    => \App\Models\Kitab::count(),
            'random_video'   => Video::inRandomOrder()->first(),
            'device'         => $device,
            'kuis_selesai'   => $device ? $device->hasilKuis()->count() : 0,
        ];

        // Get featured content
        $featuredTema = Tema::with(['jenisTema', 'video'])
            ->latest()
            ->take(5)
            ->get();

        $activeKuis = Kuis::withCount('pertanyaan')
            ->where('aktif', true)
            ->latest()
            ->take(3)
            ->get();

        return $this->successResponse([
            'stats'         => $stats,
            'featured_tema' => $featuredTema,
            'active_kuis'   => $activeKuis,
            'device'        => $device,
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->query('q');

        if (! $keyword) {
            return response()->json([
                'success' => true,
                'data'    => [],
            ]);
        }

        $results = [
            'tema' => Tema::where('nama', 'like', "%{$keyword}%")
                ->orWhere('deskripsi', 'like', "%{$keyword}%")
                ->with('jenisTema')
                ->get(),
            'kuis' => Kuis::where('judul', 'like', "%{$keyword}%")
                ->orWhere('deskripsi', 'like', "%{$keyword}%")
                ->where('aktif', true)
                ->get(),
            'video' => Video::where('judul', 'like', "%{$keyword}%")
                ->with('tema')
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data'    => $results,
        ]);
    }
}
