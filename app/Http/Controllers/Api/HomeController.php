<?php
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

/**
 * @OA\Tag(
 *     name="Home",
 *     description="API untuk halaman dashboard dan pencarian di aplikasi EKO"
 * )
 */
class HomeController extends Controller
{
    use ApiResponder;

    /**
     * @OA\Get(
     *     path="/api/home",
     *     summary="Menampilkan data dashboard utama",
     *     tags={"Home"},
     *     @OA\Parameter(
     *         name="Device-ID",
     *         in="header",
     *         required=false,
     *         description="ID perangkat pengguna (opsional)",
     *         @OA\Schema(type="string", example="d6f12b6e-0ad3-4b54-90d2-90e4123c1ef2")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dashboard data retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="stats", type="object",
     *                     @OA\Property(property="total_tema", type="integer", example=12),
     *                     @OA\Property(property="total_kuis", type="integer", example=4),
     *                     @OA\Property(property="total_video", type="integer", example=9),
     *                     @OA\Property(property="total_cp", type="integer", example=6),
     *                     @OA\Property(property="total_kaidah", type="integer", example=5),
     *                     @OA\Property(property="total_refleksi", type="integer", example=8),
     *                     @OA\Property(property="random_video", type="object"),
     *                     @OA\Property(property="device", type="object"),
     *                     @OA\Property(property="kuis_selesai", type="integer", example=2)
     *                 ),
     *                 @OA\Property(property="featured_tema", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="active_kuis", type="array", @OA\Items(type="object"))
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $deviceId = $request->header('Device-ID');

        $device = Device::where('id', $deviceId)->first();

        $stats = [
            'total_tema'     => Tema::count(),
            'total_kuis'     => Kuis::where('aktif', true)->count(),
            'total_video'    => Video::count(),
            'total_cp'       => Cp::count(),
            'total_kaidah'   => Kaidah::count(),
            'total_refleksi' => Refleksi::count(),
            'random_video'   => Video::inRandomOrder()->first(),
            'device'         => $device,
            'kuis_selesai'   => $device ? $device->hasilKuis()->count() : 0,
        ];

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

    /**
     * @OA\Get(
     *     path="/api/search",
     *     summary="Mencari data tema, kuis, dan video berdasarkan keyword",
     *     tags={"Home"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         required=true,
     *         description="Kata kunci pencarian",
     *         @OA\Schema(type="string", example="shalat")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Search results retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="tema", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="kuis", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="video", type="array", @OA\Items(type="object"))
     *             )
     *         )
     *     )
     * )
     */
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
