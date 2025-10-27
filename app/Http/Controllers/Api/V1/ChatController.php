<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Cp;
use App\Models\Dalil;
use App\Models\Device;
use App\Models\Fase;
use App\Models\Kaidah;
use App\Models\Mapel;
use App\Models\Tema;
use App\Traits\ApiResponder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Device",
 *     description="Manajemen data Chat Ai (groq)"
 * )
 */
class ChatController extends Controller
{
    use ApiResponder;

    //cp

    public function chatCp($faseId, $mapelId, $metode, $deviceId)
    {

        $fase = Fase::find($faseId);

        $mapel = Mapel::find($mapelId);

        $device = Device::where('device_id', $deviceId)->first();

        $dalil = Chat::where('jenis', 'cp')
            ->where('device_id', $device->id)
            ->where('jawaban', 'like', '% Fase : ' . $fase->nama . '%')
            ->where('jawaban', 'like', '% Mapel : ' . $mapel->nama . '%')
            ->where('jawaban', 'like', '% Metode Pembelajaran : ' . $metode . '%')
            ->get();

        return $this->successResponse($dalil, 'Chat CP proceed Successfully');
    }

    public function SendMessageCp($faseId, $mapelId, $metode, $deviceId)
    {
        // dd($faseId, $mapelId, $metode, $deviceId);
        $device = Device::where('device_id', $deviceId)->first();
        $fase   = Fase::find($faseId);
        $mapel  = Mapel::find($mapelId);

        $cp = Cp::where('fase_id', $faseId)
            ->where('mapel_id', $mapelId)
            ->where('metode_pembelajaran', $metode)
            ->latest()
            ->first();

        $previousChat = Chat::where('jenis', 'cp')
            ->where('device_id', $device->id)
            ->where('jawaban', 'like', '%' . $fase->nama . '%')
            ->where('jawaban', 'like', '%' . $mapel->nama . '%')
            ->where('jawaban', 'like', '%' . $metode . '%')
            ->latest()
            ->first();

        $latestChat = '';
        $prompt     = '';

        if ($previousChat) {
            // ambil jawaban terakhir (jika perlu)
            $lastChat   = $previousChat;
            $latestChat = "dan berikut contoh dalil yang sudah ada: {$lastChat->jawaban}";

            $prompt = "Dari fase, mapel dan contoh capaian pembelajaran berikut:\n
            Fase : {$fase->nama}
            Mapel : {$mapel->nama}\n
            Metode Pembelajaran : Di {$metode}\n
            Judul : {$cp->nama}\n
            Deskripsi : {$cp->deskripsi}\n
            Pendekatan : {$cp->pendekatan}\n
            Model : {$cp->model}\n
            Teknik : {$cp->teknik}\n
            Taktik : {$cp->taktik}\n
            Metode : {$metode}\n
            Carikan capaian pembelajaran lain dan balas hanya dengan format:\n
            Fase : {$fase->nama}
            Mapel : {$mapel->nama}\n
            Metode Pembelajaran : Di {$metode}\n
            Judul : judul cpnya\n
            Deskripsi : deskripsi cpnya\n
            Pendekatan : pendekatanya\n
            Model : modelnya\n
            Teknik : tekniknya\n
            Taktik : taktiknya\n
            Metode : metodenya\n
            {$latestChat}\n
            hanya balas dengan format tersebut";
        } else {
            $prompt = "Dari fase, mapel dan contoh capaian pembelajaran berikut:\n
            Fase : {$fase->nama}
            Mapel : {$mapel->nama}\n
            Metode Pembelajaran : Di {$metode}\n
            Judul : {$cp->nama}\n
            Deskripsi : {$cp->deskripsi}\n
            Pendekatan : {$cp->pendekatan}\n
            Model : {$cp->model}\n
            Teknik : {$cp->teknik}\n
            Taktik : {$cp->taktik}\n
            Metode : {$cp->metode}\n
            Carikan capaian pembelajaran lain dan balas hanya dengan format:\n
            Fase : {$fase->nama}
            Mapel : {$mapel->nama}\n
            Metode Pembelajaran : Di {$cp->metode}\n
            Judul : judul cpnya\n
            Deskripsi : deskripsi cpnya\n
            Pendekatan : pendekatanya\n
            Model : modelnya\n
            Teknik : tekniknya\n
            Taktik : taktiknya\n
            Metode : metodenya\n
            hanya balas dengan format tersebut";
        }

        try {
            $botReply = $this->callGroq($prompt);

            Chat::create([
                'device_id' => $device->id,
                'jenis'     => 'cp',
                'pesan'     => $prompt,
                'jawaban'   => $botReply,
            ]);

            return $this->successResponse(['reply' => $botReply], 'Message processed successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse([], $e->getMessage(), 500);
        }
    }

    //dalil

    public function chatDalil($temaId, $deviceId)
    {
        $tema = Tema::find($temaId);

        $device = Device::where('device_id', $deviceId)->first();

        $dalil = Chat::where('jenis', 'dalil')
            ->where('device_id', $device->id)
            ->where('jawaban', 'like', '%Tema : ' . $tema->nama . '%')
            ->get();

        return $this->successResponse(['chat_dalil' => $dalil], 'Chat Kaidah proceed Successfully');
    }

    public function SendMessageDalil($temaId, $deviceId, $jenis)
    {
        $device = Device::where('device_id', $deviceId)->first();
        $tema   = Tema::find($temaId);
        $dalil  = Dalil::where('jenis', $jenis)
            ->where('tema_id', $temaId)
            ->first();

        $previousChat = Chat::where('jenis', 'dalil')
            ->where('device_id', $device->id)
            ->where('jawaban', 'like', '%Tema: ' . $tema->nama . '%')
            ->latest()
            ->first();

        $latestChat = '';
        $prompt     = '';

        $jenis = ucfirst($jenis);

        if ($previousChat) {
            // ambil jawaban terakhir (jika perlu)
            $lastChat   = $previousChat;
            $latestChat = "dan berikut contoh dalil yang sudah ada: {$lastChat->jawaban}";

            $prompt = "Dari tema dan contoh dalil berikut:\n
            Tema : {$tema->nama}
            Jenis : {$jenis}\n
            Dalil : {$dalil->teks_asli}\n
            Terjemahan : {$dalil->terjemahan}\n
            Sumber : {$dalil->sumber}\n
            Penjelasan : {$dalil->penjelasan}\n
            Carikan dalil lain dan balas hanya dengan format:\n
            Tema : {$tema->nama}\n
            Jenis : {$jenis} \n
            Dalil : dalilnya \n
            Latin : tulis transliterasi huruf Arab ke huruf Latin (misal 'al-khairu min al-khairi', bukan bahasa Latin Eropa)
            Sumber : sumbernya\n
            Terjemahan : terjemahannya\n
            Penjelasan : penjelasannya\n
            {$latestChat}\n
            hanya balas dengan format tersebut";
        } else {
            $prompt = "Dari tema dan contoh dalil berikut:\n
            Tema : {$tema->nama}
            Jenis : {$jenis}\n
            Dalil : {$dalil->teks_asli}\n
            Terjemahan : {$dalil->terjemahan}\n
            Penjelasan : {$dalil->penjelasan}\n
            Carikan dalil lain dan balas hanya dengan format :\n
            Tema : {$tema->nama}\n
            Jenis : {$jenis}\n
            Dalil : dalilnya\n
            Sumber : sumbernya\n
            Latin : tulis transliterasi huruf Arab ke huruf Latin (misal 'al-khairu min al-khairi', bukan bahasa Latin Eropa)
            Terjemahan : terjemahan\n
            Penjelasan : penjelasanya\n
            hanya balas dengan format tersebut";
        }

        try {
            $botReply = $this->callGroq($prompt);

            Chat::create([
                'device_id' => $device->id,
                'jenis'     => 'dalil',
                'pesan'     => $prompt,
                'jawaban'   => $botReply,
            ]);

            return $this->successResponse(['reply' => $botReply], 'Message processed successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse([], $e->getMessage(), 500);
        }
    }

    //kaidah
    public function chatKaidah($temaId, $deviceId)
    {
        $tema = Tema::find($temaId);

        $device = Device::where('device_id', $deviceId)->first();

        $kaidah = Chat::where('jenis', 'kaidah')->where('device_id', $device->id)
            ->where('jawaban', 'like', '%Tema: ' . $tema->nama . '%')
            ->get();

        return $this->successResponse($kaidah, 'Chat Kaidah proceed Successfully');

    }

    public function SendMessageKaidah($temaId, $deviceId, $jenis)
    {
        $device = Device::where('device_id', $deviceId)->first();
        $tema   = Tema::find($temaId);
        $kaidah = Kaidah::where('jenis_kaidah', $jenis)
            ->where('tema_id', $temaId)
            ->first();

        $previousChat = Chat::where('jenis', 'kaidah')
            ->where('device_id', $device->id)
            ->where('jawaban', 'like', '%Tema: ' . $tema->nama . '%')
            ->where('jawaban', 'like', '%Jenis Kaidah: ' . ucfirst($jenis) . '%')
            ->latest()
            ->first();

        $latestChat = '';
        $prompt     = '';

        $jenis = ucfirst($jenis);

        if ($previousChat) {
            // ambil jawaban terakhir (jika perlu)
            $lastChat   = $previousChat;
            $latestChat = "dan berikut contoh kaidah yang sudah ada: {$lastChat->jawaban}";

            $prompt = "Dari tema dan contoh kaidah berikut:
            Tema: {$tema->nama}
            Jenis kaidah: {$jenis}
            Kaidah: {$kaidah->kaidah}
            Terjemahan: {$kaidah->terjemahan}
            Penjelasan: {$kaidah->deskripsi}

            Carikan satu kaidah lain yang masih berkaitan, lalu balas hanya dengan format berikut (jangan gunakan bahasa Latin klasik seperti 'bonum' atau 'malum'):

            Tema: {$tema->nama}
            Jenis Kaidah: {$jenis}
            Kaidah: tulis teks Arab-nya
            Kaidah Latin: tulis transliterasi huruf Arab ke huruf Latin (misal 'al-khairu min al-khairi', bukan bahasa Latin Eropa)
            Terjemahan: tulis arti kaidah dalam bahasa Indonesia
            Penjelasan: tulis penjelasan singkat tentang makna kaidah

            {$latestChat}";

        } else {
            $prompt = "Dari tema dan contoh kaidah berikut:
            Tema: {$tema->nama}
            Jenis kaidah: {$jenis}
            Kaidah: {$kaidah->kaidah}
            Terjemahan: {$kaidah->terjemahan}
            Penjelasan: {$kaidah->deskripsi}

            Carikan satu kaidah lain yang masih berkaitan, lalu balas hanya dengan format berikut (jangan gunakan bahasa Latin klasik seperti 'bonum' atau 'malum'):

            Tema: {$tema->nama}
            Jenis Kaidah: {$jenis}
            Kaidah: tulis teks Arab-nya
            Kaidah Latin: tulis transliterasi huruf Arab ke huruf Latin (misal 'al-khairu min al-khairi', bukan bahasa Latin Eropa)
            Terjemahan: tulis arti kaidah dalam bahasa Indonesia
            Penjelasan: tulis penjelasan singkat tentang makna kaidah";
        }

        try {
            $botReply = $this->callGroq($prompt);

            Chat::create([
                'device_id' => $device->id,
                'jenis'     => 'kaidah',
                'pesan'     => $prompt,
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
            throw $e; // Lempar ulang exception
        }
    }
}
