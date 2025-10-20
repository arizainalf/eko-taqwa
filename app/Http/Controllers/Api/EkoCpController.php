<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cp;
use App\Models\Fase;
use App\Models\Mapel;
use App\Traits\ApiResponder;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Info(
 *     title="API Eko CP",
 *     version="1.0.0",
 *     description="Dokumentasi API untuk data Fase, Mapel, dan CP."
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Server utama"
 * )
 */
class EkoCpController extends Controller
{
    use ApiResponder;

    /**
     * @OA\Get(
     *     path="/api/fase",
     *     summary="Ambil semua data fase dan jumlah mapel",
     *     tags={"Fase"},
     *     @OA\Response(
     *         response=200,
     *         description="Data fase dan mapel berhasil diambil"
     *     )
     * )
     */
    public function fase()
    {
        $fase  = Fase::all();
        $mapel = Mapel::count();
        $cp    = Cp::count();

        $data = [
            'total_mapel' => $mapel,
            'fase'        => $fase,
            'total_cps'   => $cp,
        ];

        return $this->successResponse($data, 'Fase and Mapel data retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/fase/{faseId}/mapel",
     *     summary="Ambil semua mapel berdasarkan ID fase",
     *     tags={"Mapel"},
     *     @OA\Parameter(
     *         name="faseId",
     *         in="path",
     *         required=true,
     *         description="ID Fase",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data mapel berhasil diambil"
     *     )
     * )
     */
    public function mapel($faseId)
    {
        $mapel = Mapel::withCount(['cp' => function ($query) use ($faseId) {
            $query->where('fase_id', $faseId);
        }])->get();
        $cp   = Cp::where('fase_id', $faseId)->count();
        $fase = Fase::find($faseId);
        $data = [
            'total_mapel' => $mapel->count(),
            'mapel'       => $mapel,
            'total_cp'    => $cp,
            'fase'        => $fase,
        ];

        return $this->successResponse($data, 'Mapel data retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/fase/{faseId}/mapel/{mapelId}/metode",
     *     summary="Ambil metode pembelajaran berdasarkan fase dan mapel",
     *     tags={"Metode Pembelajaran"},
     *     @OA\Parameter(
     *         name="faseId",
     *         in="path",
     *         required=true,
     *         description="ID Fase",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="mapelId",
     *         in="path",
     *         required=true,
     *         description="ID Mapel",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Metode pembelajaran berhasil diambil"
     *     )
     * )
     */
    public function metodePembelajaran($faseId, $mapelId)
    {
        $metode = Cp::query()
            ->select('metode_pembelajaran', DB::raw('COUNT(*) as total'))
            ->groupBy('metode_pembelajaran')
            ->where('fase_id', $faseId)
            ->where('mapel_id', $mapelId)
            ->get();
        $data = [
            'fase_id'  => $faseId,
            'mapel_id' => $mapelId,
            'metode'   => $metode,
        ];

        return $this->successResponse($data, 'MP data retrieved successfully');
    }

    /**
     * @OA\Get(
     *     path="/api/fase/{faseId}/mapel/{mapelId}/mp/{metode}",
     *     summary="Ambil data CP berdasarkan fase, mapel, dan metode pembelajaran",
     *     tags={"Capaian Pembelajaran"},
     *     @OA\Parameter(
     *         name="faseId",
     *         in="path",
     *         required=true,
     *         description="ID Fase",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="mapelId",
     *         in="path",
     *         required=true,
     *         description="ID Mapel",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="metode",
     *         in="path",
     *         required=true,
     *         description="Metode Pembelajaran",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data CP berhasil diambil"
     *     )
     * )
     */
    public function cpByFaseMapelMP($faseId, $mapelId, $metode)
    {
        $cp = Cp::where('fase_id', $faseId)
            ->where('mapel_id', $mapelId)
            ->where('metode_pembelajaran', $metode)
            ->get();

        if ($cp->isEmpty()) {
            return $this->errorResponse([], 'No CP data found for the given criteria.', 404);
        }

        return $this->successResponse($cp, 'CP data retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/cp/{id}",
     *     summary="Lihat detail CP berdasarkan ID",
     *     tags={"Capaian Pembelajaran"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID CP",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail CP berhasil diambil"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="CP tidak ditemukan"
     *     )
     * )
     */
    public function showCp($id)
    {
        $cp = Cp::find($id);

        if (! $cp) {
            return $this->errorResponse([], 'CP not found', 404);
        }

        return $this->successResponse($cp, 'CP detail retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/cp",
     *     summary="Ambil semua data CP",
     *     tags={"Capaian Pembelajaran"},
     *     @OA\Response(
     *         response=200,
     *         description="Semua data CP berhasil diambil"
     *     )
     * )
     */
    public function allCp()
    {
        $cp = Cp::all();
        return $this->successResponse($cp, 'All CP data retrieved successfully.');
    }
}
