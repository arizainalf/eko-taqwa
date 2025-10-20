<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dalil;
use App\Models\JenisTema;
use App\Models\Tema;
use App\Traits\ApiResponder;

/**
 * @OA\Tag(
 *     name="Ayat & Hadist",
 *     description="API untuk mengambil data Jenis Tema, Tema, dan Ayat/Hadist"
 * )
 */
class EkoAyatHadistController extends Controller
{
    use ApiResponder;

    /**
     * @OA\Get(
     *     path="/api/jenis-tema",
     *     summary="Ambil semua jenis tema",
     *     tags={"Ayat & Hadist"},
     *     @OA\Response(
     *         response=200,
     *         description="Daftar Jenis Tema berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama_jenis", type="string", example="Akidah")
     *             )),
     *             @OA\Property(property="message", type="string", example="List of Jenis Tema retrieved successfully.")
     *         )
     *     )
     * )
     */
    public function jenisTema()
    {
        $jenisTema = JenisTema::all();
        return $this->successResponse($jenisTema, 'List of Jenis Tema retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/tema",
     *     summary="Ambil semua tema",
     *     tags={"Ayat & Hadist"},
     *     @OA\Response(
     *         response=200,
     *         description="Daftar Tema berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama_tema", type="string", example="Kebersihan dalam Islam")
     *             )),
     *             @OA\Property(property="message", type="string", example="List of Tema retrieved successfully.")
     *         )
     *     )
     * )
     */
    public function tema($jenisTemaId)
    {
        $tema      = Tema::where('jenis_tema_id', $jenisTemaId)->withCount('dalil')->get();
        $jenistema = JenisTema::find($jenisTemaId);
        $data      = [
            'jenistema' => $jenistema,
            'tema'      => $tema,
        ];
        return $this->successResponse($data, 'List of Tema retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/tema/{tema_id}/dalil",
     *     summary="Ambil semua ayat/hadist berdasarkan tema ID",
     *     tags={"Ayat & Hadist"},
     *     @OA\Parameter(
     *         name="tema_id",
     *         in="path",
     *         required=true,
     *         description="ID Tema",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Daftar ayat/hadist berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=10),
     *                 @OA\Property(property="content", type="string", example="Bersihkanlah dirimu, sesungguhnya kebersihan adalah sebagian dari iman."),
     *                 @OA\Property(property="sumber", type="string", example="HR. Muslim")
     *             )),
     *             @OA\Property(property="message", type="string", example="List of Ayat and Hadist retrieved successfully.")
     *         )
     *     )
     * )
     */
    public function ayatHadist($tema_id)
    {
        $ayatHadist = Dalil::where('tema_id', $tema_id)->get();
        $tema       = Tema::find($tema_id);
        $data       = [
            'dalil' => $ayatHadist,
            'tema'  => $tema,
        ];
        return $this->successResponse($data, 'List message: of Ayat and Hadist retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/dalil/{id}",
     *     summary="Lihat detail ayat/hadist berdasarkan ID",
     *     tags={"Ayat & Hadist"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Dalil",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail ayat/hadist berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=10),
     *                 @OA\Property(property="content", type="string", example="Sesungguhnya amal itu tergantung pada niat."),
     *                 @OA\Property(property="sumber", type="string", example="HR. Bukhari")
     *             ),
     *             @OA\Property(property="message", type="string", example="Ayat or Hadist detail retrieved successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ayat atau Hadist tidak ditemukan"
     *     )
     * )
     */
    public function showAyatHadist($id)
    {
        $ayatHadist = Dalil::find($id);

        if (! $ayatHadist) {
            return $this->errorResponse('', 'Ayat or Hadist not found', 404);
        }

        return $this->successResponse($ayatHadist, 'Ayat or Hadist detail retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/dalil/search/{query}",
     *     summary="Cari ayat/hadist berdasarkan kata kunci",
     *     tags={"Ayat & Hadist"},
     *     @OA\Parameter(
     *         name="query",
     *         in="path",
     *         required=true,
     *         description="Kata kunci pencarian dalam teks dalil",
     *         @OA\Schema(type="string", example="iman")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hasil pencarian ayat/hadist berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=3),
     *                 @OA\Property(property="content", type="string", example="Kebersihan sebagian dari iman"),
     *                 @OA\Property(property="sumber", type="string", example="HR. Muslim")
     *             )),
     *             @OA\Property(property="message", type="string", example="Search results retrieved successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tidak ditemukan hasil pencarian"
     *     )
     * )
     */
    public function searchAyatHadist($query)
    {
        $results = Dalil::where('content', 'LIKE', '%' . $query . '%')->get();

        if ($results->isEmpty()) {
            return $this->errorResponse([], 'No Ayat or Hadist found matching the query.', 404);
        }

        return $this->successResponse($results, 'Search results retrieved successfully.');
    }
}
