<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisTema;
use App\Models\Tema;
use App\Traits\ApiResponder;

/**
 * @OA\Tag(
 *     name="Kaidah",
 *     description="API untuk mengambil data Jenis Tema, Tema, dan Kaidah"
 * )
 */
class EkoKaidahController extends Controller
{
    use ApiResponder;

    /**
     * @OA\Get(
     *     path="/api/kaidah/jenis-tema",
     *     summary="Ambil semua jenis tema untuk kaidah",
     *     tags={"Kaidah"},
     *     @OA\Response(
     *         response=200,
     *         description="Daftar Jenis Tema berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama_jenis", type="string", example="Fiqih")
     *             )),
     *             @OA\Property(property="message", type="string", example="List of Jenis Tema retrieved successfully.")
     *         )
     *     )
     * )
     */
    public function jenisTema()
    {
        $jenisTema = JenisTema::withCount('tema')->get();
        return $this->successResponse($jenisTema, 'List of Jenis Tema retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/kaidah/tema",
     *     summary="Ambil semua tema untuk kaidah",
     *     tags={"Kaidah"},
     *     @OA\Response(
     *         response=200,
     *         description="Daftar Tema berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=2),
     *                 @OA\Property(property="nama_tema", type="string", example="Etika Lingkungan")
     *             )),
     *             @OA\Property(property="message", type="string", example="List of Tema retrieved successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tema tidak ditemukan"
     *     )
     * )
     */
    public function tema($jenisTemaId)
    {
        $tema = Tema::where('jenis_tema_id', $jenisTemaId)->withCount('kaidah')->get();

        if (! $tema) {
            return $this->errorResponse('', 'Tema not found', 404);
        } elseif ($tema->isEmpty()) {
            return $this->errorResponse([], 'No Tema found.', 404);
        }

        return $this->successResponse($tema, 'List of Tema retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/kaidah/tema/{tema_id}/kaidah",
     *     summary="Ambil semua kaidah berdasarkan tema ID",
     *     tags={"Kaidah"},
     *     @OA\Parameter(
     *         name="tema_id",
     *         in="path",
     *         required=true,
     *         description="ID Tema untuk kaidah",
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Daftar Kaidah berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=15),
     *                 @OA\Property(property="judul", type="string", example="Kaidah menjaga lingkungan"),
     *                 @OA\Property(property="isi", type="string", example="Menjaga kebersihan merupakan bagian dari iman.")
     *             )),
     *             @OA\Property(property="message", type="string", example="List of Kaidah retrieved successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Kaidah tidak ditemukan"
     *     )
     * )
     */
    public function kaidah($tema_id)
    {
        $tema = Tema::find($tema_id);

        if (! $tema) {
            return $this->errorResponse('', 'Tema not found', 404);
        }

        $kaidah = $tema->kaidah;

        if (! $kaidah) {
            return $this->errorResponse('', 'Kaidah not found', 404);
        } elseif ($kaidah->isEmpty()) {
            return $this->errorResponse([], 'No Kaidah found for the given Tema.', 404);
        }

        return $this->successResponse($kaidah, 'List of Kaidah retrieved successfully.');
    }
}
