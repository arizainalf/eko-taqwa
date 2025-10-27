<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Device;
use App\Models\HasilKuis;
use App\Models\Kuis;
use App\Models\Pertanyaan;
use App\Models\Refleksi;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EkoRefleksiController extends Controller
{
    use ApiResponder;

    /**
     * @OA\Get(
     *     path="/api/refleksi",
     *     summary="Get list of refleksi menu",
     *     description="Mengambil daftar menu utama Refleksi seperti Kuis, Tanya Jawab, dan Refleksi Harian.",
     *     tags={"Eko Refleksi"},
     *     @OA\Response(
     *         response=200,
     *         description="List of Refleksi options retrieved successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(type="string", example="Kuis")),
     *             @OA\Property(property="message", type="string", example="List of Refleksi options retrieved successfully.")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $data = [
            'kuis'     => Kuis::count(),
            'chat'     => Chat::distinct()->count('device_id'),
            'refleksi' => Refleksi::count(),
        ];

        return $this->successResponse($data, 'List of Refleksi options retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/refleksi/kuis",
     *     summary="Get list of kuis",
     *     tags={"Eko Refleksi"},
     *     description="Mengambil daftar kuis yang tersedia dan jumlah hasil kuis yang tersimpan.",
     *     @OA\Response(
     *         response=200,
     *         description="Data Kuis retrieved successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="total_kuis", type="integer", example=3),
     *             @OA\Property(property="total_hasil_kuis", type="integer", example=10),
     *             @OA\Property(property="kuis", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="string", example="uuid-kuis"),
     *                 @OA\Property(property="judul", type="string", example="Kuis Lingkungan"),
     *                 @OA\Property(property="deskripsi", type="string", example="Tes pemahaman tentang lingkungan")
     *             ))
     *         )
     *     )
     * )
     */
    public function kuis()
    {
        $kuis      = Kuis::select('id', 'judul', 'deskripsi')->withCount('pertanyaan')->get();
        $hasilKuis = HasilKuis::count();

        $data = [
            'total_kuis'       => $kuis->count(),
            'total_hasil_kuis' => $hasilKuis,
            'kuis'             => $kuis,
        ];

        return $this->successResponse($data, 'Data Kuis retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/refleksi/kuis/{id}/{device_id}",
     *     summary="Get detail of specific kuis for a device",
     *     description="Mengambil detail kuis beserta status pengerjaan oleh device tertentu.",
     *     tags={"Eko Refleksi"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="device_id", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Kuis detail retrieved successfully.")
     * )
     */
    public function kuisDetail($id, $device_id)
    {
        $kuis   = Kuis::find($id);
        $device = Device::where('device_id', $device_id)->first();

        $done = HasilKuis::where('kuis_id', $id)
            ->where('device_id', $device->id)->orderBy('created_at', 'DESC')
            ->first();
        $done_count = HasilKuis::count();

        $data = [
            'kuis'         => $kuis,
            'diselesaikan' => $done_count,
            'hasil_kuis'   => $done,
        ];

        return $this->successResponse($data, 'Kuis detail retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/refleksi/pertanyaan/{kuis_id}",
     *     summary="Get next pertanyaan for a kuis",
     *     tags={"Eko Refleksi"},
     *     @OA\Parameter(name="kuis_id", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Parameter(name="offset", in="query", required=false, @OA\Schema(type="integer", example=0)),
     *     @OA\Response(response=200, description="Pertanyaan berhasil diambil.")
     * )
     */
    public function pertanyaan($kuis_id, Request $request)
    {
        $offset = (int) $request->input('offset', 0);
        $total  = Pertanyaan::where('kuis_id', $kuis_id)->count();

        $pertanyaan = Pertanyaan::with('opsipertanyaan')
            ->where('kuis_id', $kuis_id)
            ->skip($offset)
            ->take(1)
            ->first();

        if (! $pertanyaan) {
            return $this->errorResponse('Tidak ada pertanyaan lagi.', 404);
        }

        $nomor = $offset + 1;

        $data = [
            'nomor'      => $nomor,
            'total'      => $total,
            'pertanyaan' => [
                'id'              => $pertanyaan->id,
                'teks_pertanyaan' => $pertanyaan->teks_pertanyaan,
                'poin'            => $pertanyaan->poin,
                'opsi'            => $pertanyaan->opsipertanyaan->map(fn($opsi) => [
                    'id'      => $opsi->id,
                    'jawaban' => $opsi->jawaban,
                ]),
            ],
        ];

        return $this->successResponse($data, 'Pertanyaan berhasil diambil.');
    }

    /**
     * @OA\Post(
     *     path="/api/refleksi/kuis/simpan",
     *     summary="Simpan hasil kuis",
     *     tags={"Eko Refleksi"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_id","kuis_id","jawaban","waktu_pengerjaan"},
     *             @OA\Property(property="device_id", type="string"),
     *             @OA\Property(property="kuis_id", type="string"),
     *             @OA\Property(property="jawaban", type="object"),
     *             @OA\Property(property="waktu_pengerjaan", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Hasil kuis berhasil disimpan.")
     * )
     */
    public function simpanHasil(Request $request)
    {
        $validated = $request->validate([
            'device_id'        => 'required',
            'kuis_id'          => 'required|uuid',
            'jawaban'          => 'required|array',
            'waktu_pengerjaan' => 'required|integer',
        ]);

        $device = Device::where('device_id', $validated['device_id'])->first();

        $validated['device_id'] = $device->id;

        $pertanyaanList = Pertanyaan::where('kuis_id', $validated['kuis_id'])->get();

        $benar = 0;
        foreach ($pertanyaanList as $p) {
            $opsiBenar = $p->opsipertanyaan()->where('benar', true)->first();
            if (isset($validated['jawaban'][$p->id]) &&
                $validated['jawaban'][$p->id] == $opsiBenar->id) {
                $benar++;
            }
        }

        $hasil = HasilKuis::create([
            'id'               => Str::uuid(),
            'device_id'        => $validated['device_id'],
            'kuis_id'          => $validated['kuis_id'],
            'skor'             => $benar,
            'total_pertanyaan' => $pertanyaanList->count(),
            'jawaban_benar'    => $benar,
            'jawaban_salah'    => $pertanyaanList->count() - $benar,
            'waktu_pengerjaan' => $validated['waktu_pengerjaan'],
            'jawaban'          => $validated['jawaban'],
        ]);

        return $this->successResponse($hasil, 'Hasil kuis berhasil disimpan.');
    }

    /**
     * @OA\Get(
     *     path="/api/refleksi/harian",
     *     summary="Get list of refleksi harian",
     *     tags={"Eko Refleksi"},
     *     @OA\Response(response=200, description="List of Refleksi retrieved successfully.")
     * )
     */
    public function refleksiHarian()
    {
        $refleksi = Refleksi::with('device')
            ->latest()
            ->get();
        return $this->successResponse($refleksi, 'List of Refleksi retrieved successfully.');
    }
    public function showRefleksiHarian($id)
    {
        $refleksi = Refleksi::with('device')->find($id);
        return $this->successResponse($refleksi, 'List of Refleksi retrieved successfully.');
    }

    public function updateRefleksiHarian(Request $request, $id)
    {
        try {
            $refleksi = Refleksi::findOrFail($id);

            $validated = $request->validate([
                'judul'        => 'required|string|max:255',
                'deskripsi'    => 'nullable|string',
                'tanggal'      => 'required|date',
                'gambar'       => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
                'hapus_gambar' => 'sometimes|string|in:1,0,true,false',
            ]);

            // Convert string ke boolean
            $hapusGambar = in_array($request->hapus_gambar, ['1', 'true']);

            $refleksi->judul     = $validated['judul'];
            $refleksi->deskripsi = $validated['deskripsi'];
            $refleksi->tanggal   = $validated['tanggal'];

            // Handle penghapusan gambar
            if ($hapusGambar) {
                if ($refleksi->gambar) {
                    // Hapus file dari storage
                    $path = 'refleksi/' . basename($refleksi->gambar);
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                    $refleksi->gambar = null;
                }
            }

            // Handle upload gambar baru
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($refleksi->gambar) {
                    $oldPath = 'refleksi/' . basename($refleksi->gambar);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                // Upload gambar baru - SIMPAN SEBAGAI PATH, BUKAN URL
                $image     = $request->file('gambar');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('refleksi', $imageName, 'public');

                                                // SIMPAN PATH RELATIVE, BUKAN URL LENGKAP
                $refleksi->gambar = $imagePath; // 'refleksi/image_name.jpg'
            }

            $refleksi->save();

            return $this->successResponse($refleksi, 'Refleksi updated successfully');

        } catch (\Exception $e) {
            return $this->errorResponse('', $e->getMessage());
        }
    }
    public function editRefleksiHarian($id, Request $request)
    {
        $refleksi = Refleksi::findOrFail($id);

        $validated = $request->validate([
            'gambar'    => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal'   => 'required|date',
        ]);

        try {
            // Handle upload gambar jika ada
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($refleksi->gambar) {
                    $oldImagePath = 'refleksi/' . basename($refleksi->gambar);
                    if (Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                }

                // Upload gambar baru ke directory 'refleksi' di disk 'public'
                $gambarPath          = $request->file('gambar')->store('refleksi', 'public');
                $validated['gambar'] = $gambarPath;
            }

            // Update data
            $refleksi->update($validated);

            return $this->successResponse($refleksi, 'refleksi success edited');

        } catch (\Exception $e) {
            return $this->errorResponse('', $e->getMessage());
        }
    }

    public function deleteRefleksiHarian($id)
    {
        try {
            $refleksi = Refleksi::findOrFail($id);

            // Hapus gambar dari storage jika ada
            if ($refleksi->gambar) {
                // Cek format penyimpanan gambar di database
                if (filter_var($refleksi->gambar, FILTER_VALIDATE_URL)) {
                    // Jika berupa URL, extract path-nya
                    $path = 'refleksi/' . basename($refleksi->gambar);
                } else if (str_contains($refleksi->gambar, 'refleksi/')) {
                    // Jika sudah dalam format path
                    $path = $refleksi->gambar;
                } else {
                    // Jika hanya nama file
                    $path = 'refleksi/' . $refleksi->gambar;
                }

                // Hapus file dari storage
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            // Hapus data dari database
            $refleksi->delete();

            return $this->successResponse(null, 'refleksi deleted successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse('', $e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/refleksi/harian/store",
     *     summary="Store new refleksi harian",
     *     tags={"Eko Refleksi"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"device_id","judul","refleksi","tanggal","deskripsi"},
     *                 @OA\Property(property="device_id", type="string"),
     *                 @OA\Property(property="judul", type="string"),
     *                 @OA\Property(property="refleksi", type="string"),
     *                 @OA\Property(property="tanggal", type="string", format="date"),
     *                 @OA\Property(property="deskripsi", type="string"),
     *                 @OA\Property(property="gambar", type="file")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Refleksi created successfully.")
     * )
     */
    public function storeRefleksi(Request $request)
    {
        logger('Request Data:', $request->all());
        logger('Files:', $request->file() ? ['has_file' => true] : ['has_file' => false]);
        $validated = $request->validate([
            'device_id' => 'required',
            'gambar'    => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'judul'     => 'required|string',
            'tanggal'   => 'required|date',
            'deskripsi' => 'required|string',
        ]);

        $device = Device::where('device_id', $validated['device_id'])->first();

        $validated['device_id'] = $device->id;

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('refleksi', 'public');
        }

        $validated['id'] = Str::uuid();
        $refleksi        = Refleksi::create($validated);

        return $this->successResponse($refleksi, 'Refleksi created successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/refleksi/chat/{deviceId}",
     *     summary="Get chat history by device ID",
     *     tags={"Eko Refleksi"},
     *     @OA\Parameter(name="deviceId", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Chat history retrieved successfully.")
     * )
     */
    public function chat($deviceId)
    {
        try {
            $device = Device::where('device_id', $deviceId)->first();

            if (! $device) {
                return $this->errorResponse([], 'Device not found', 404);
            }

            $chats = Chat::where('device_id', $device->id)->where('jenis', 'chat')->get();
            return $this->successResponse($chats, 'Chat history retrieved successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse([], $e->getMessage(), 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/refleksi/chat/send",
     *     summary="Send a message to Groq chatbot",
     *     tags={"Eko Refleksi"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_id","message"},
     *             @OA\Property(property="device_id", type="string"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Message processed successfully.")
     * )
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:device,device_id',
            'message'   => 'required|string',
        ]);

        $device = Device::where('device_id', $request->device_id)->first();

        if (! $device) {
            return $this->errorResponse([], 'Device not found', 404);
        }

        try {
            $botReply = $this->callGroqWithContext($request->message, $device->device_id);

            Chat::create([
                'device_id' => $device->id,
                'pesan'     => $request->message,
                'jawaban'   => $botReply,
            ]);

            return $this->successResponse(['reply' => $botReply], 'Message processed successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse([], $e->getMessage(), 500);
        }
    }

    private function callGroq(string $message): string
    {
        try {
            // Hapus spasi berlebih di URL!
            $response = Http::withToken(env('GROQ_API_KEY'))
                ->timeout(30)
                ->post('https://api.groq.com/openai/v1/chat/completions', [ // ← spasi dihapus
                    'model'       => 'llama-3.1-8b-instant',
                    'messages'    => [
                        ['role' => 'user', 'content' => $message],
                    ],
                    'temperature' => 0.7,
                    'max_tokens'  => 1000,
                ]);

            if ($response->failed()) {
                $errorBody = $response->body();
                Log::error('Groq API Error', [
                    'status' => $response->status(),
                    'body'   => $errorBody,
                ]);

                // Ambil pesan error dari Groq jika ada
                $errorMessage = 'Groq API request failed';
                if ($response->json('error.message')) {
                    $errorMessage = $response->json('error.message');
                }

                throw new \Exception($errorMessage);
            }

            $data  = $response->json();
            $reply = $data['choices'][0]['message']['content'] ?? null;

            if (empty($reply)) {
                throw new \Exception('Empty response from Groq');
            }

            return $reply;

        } catch (\Exception $e) {
            Log::error('Groq Exception', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            throw $e; // Lempar ulang exception
        }
    }

    private function callGroqWithContext(string $message, string $deviceId): string
    {
        // Ambil riwayat (5 percakapan terakhir)
        $history = Chat::where('device_id', $deviceId)
            ->where('jenis', 'chat')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->orderBy('created_at', 'asc')
            ->get();

        $messages = [
            ['role' => 'system', 'content' => 'You are a helpful assistant.'],
        ];

        foreach ($history as $chat) {
            $messages[] = ['role' => 'user', 'content' => $chat->pesan];
            $messages[] = ['role' => 'assistant', 'content' => $chat->jawaban];
        }

        $messages[] = ['role' => 'user', 'content' => $message];

        // Kirim ke Groq

        try {
            // Hapus spasi berlebih di URL!
            $response = Http::withToken(env('GROQ_API_KEY'))
                ->timeout(30)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model'       => 'llama-3.1-8b-instant',
                    'messages'    => $messages,
                    'temperature' => 0.7,
                    'max_tokens'  => 1000,
                ]);

            if ($response->failed()) {
                $errorBody = $response->body();
                Log::error('Groq API Error', [
                    'status' => $response->status(),
                    'body'   => $errorBody,
                ]);

                // Ambil pesan error dari Groq jika ada
                $errorMessage = 'Groq API request failed';
                if ($response->json('error.message')) {
                    $errorMessage = $response->json('error.message');
                }

                throw new \Exception($errorMessage);
            }

            $remainingRequests = $response->header('x-ratelimit-remaining-requests');
            $remainingTokens   = $response->header('x-ratelimit-remaining-tokens');

            Log::info('Groq Rate Limit', [
                'remaining_requests' => $remainingRequests,
                'remaining_tokens'   => $remainingTokens,
            ]);

            $data  = $response->json();
            $reply = $data['choices'][0]['message']['content'] ?? null;

            if (empty($reply)) {
                throw new \Exception('Empty response from Groq');
            }

            return $reply;

        } catch (\Exception $e) {
            Log::error('Groq Exception', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}
