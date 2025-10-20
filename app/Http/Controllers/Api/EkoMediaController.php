<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisTema;
use App\Models\Tema;
use App\Models\Video;
use App\Traits\ApiResponder;

/**
 * @OA\Tag(
 *     name="Media",
 *     description="API untuk mengambil data Jenis Tema, Tema, dan Media (Video)"
 * )
 */
class EkoMediaController extends Controller
{
    use ApiResponder;

    /**
     * @OA\Get(
     *     path="/api/media/jenis-tema",
     *     summary="Ambil semua Jenis Tema untuk media",
     *     tags={"Media"},
     *     @OA\Response(
     *         response=200,
     *         description="Daftar Jenis Tema berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama_jenis", type="string", example="Akidah Akhlak")
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
     *     path="/api/media/jenis-tema/{jenis_tema_id}/tema",
     *     summary="Ambil semua Tema berdasarkan Jenis Tema ID",
     *     tags={"Media"},
     *     @OA\Parameter(
     *         name="jenis_tema_id",
     *         in="path",
     *         required=true,
     *         description="ID Jenis Tema",
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Daftar Tema berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=3),
     *                 @OA\Property(property="nama_tema", type="string", example="Kebersihan Sebagian dari Iman")
     *             )),
     *             @OA\Property(property="message", type="string", example="List of Tema retrieved successfully.")
     *         )
     *     )
     * )
     */
    public function tema($jenisTemaId)
    {
        $tema = Tema::where('jenis_tema_id', $jenisTemaId)->withCount('video')->get();
        return $this->successResponse($tema, 'List of Tema retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/media/tema/{tema_id}/video",
     *     summary="Ambil semua media (video) berdasarkan Tema ID",
     *     tags={"Media"},
     *     @OA\Parameter(
     *         name="tema_id",
     *         in="path",
     *         required=true,
     *         description="ID Tema",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Daftar Media berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=5),
     *                 @OA\Property(property="judul", type="string", example="Menjaga Kebersihan"),
     *                 @OA\Property(property="url", type="string", example="https://youtube.com/embed/xxxx")
     *             )),
     *             @OA\Property(property="message", type="string", example="List of Media retrieved successfully.")
     *         )
     *     )
     * )
     */
    public function media($temaId)
    {
        $media = Video::with('tema')->where('tema_id', $temaId)->get();
        return $this->successResponse($media, 'List of Media retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/media/{id}",
     *     summary="Ambil detail media berdasarkan ID",
     *     tags={"Media"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Media (Video)",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail Media berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=10),
     *                 @OA\Property(property="judul", type="string", example="Video Pembelajaran Akhlak"),
     *                 @OA\Property(property="url", type="string", example="https://youtu.be/abcd1234")
     *             ),
     *             @OA\Property(property="message", type="string", example="Media detail retrieved successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Media tidak ditemukan"
     *     )
     * )
     */
    public function showMedia($id)
    {
        $media = Video::find($id);

        if (! $media) {
            return $this->errorResponse('', 'Media not found', 404);
        }

        return $this->successResponse($media, 'Media detail retrieved successfully.');
    }
}
