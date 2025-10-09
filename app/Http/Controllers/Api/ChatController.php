<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Device;
use App\Traits\ApiResponder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    use ApiResponder;

    /**
     * Kirim pesan ke Groq API.
     *
     * @throws Exception Jika Groq API gagal
     */
    private function callGroq(string $message): string
    {
        try {
            // Hapus spasi berlebih di URL!
            $response = Http::withToken(env('GROQ_API_KEY'))
                ->timeout(30)
                ->post('https://api.groq.com/openai/v1/chat/completions', [ // ← spasi dihapus
                    'model'       => 'llama3-8b-8192',
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

                throw new Exception($errorMessage);
            }

            $data  = $response->json();
            $reply = $data['choices'][0]['message']['content'] ?? null;

            if (empty($reply)) {
                throw new Exception('Empty response from Groq');
            }

            return $reply;

        } catch (Exception $e) {
            Log::error('Groq Exception', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            throw $e; // Lempar ulang exception
        }
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'device_id' => 'required|uuid|exists:device,id',
            'message'   => 'required|string',
        ]);

        $device = Device::where("device_id","%like%",$request->device_id);

        try {
            $botReply = $this->callGroq($request->message);

            // Hanya simpan ke DB jika berhasil
            Chat::create([
                'device_id' => $device->id,
                'pesan'     => $request->message,
                'jawaban'   => $botReply,
            ]);

            return $this->successResponse(['reply' => $botReply], 'Message processed successfully.');

        } catch (Exception $e) {
            // Jangan simpan ke DB jika error
            return $this->errorResponse(
                [],
                $e->getMessage(),
                500
            );
        }
    }
}
