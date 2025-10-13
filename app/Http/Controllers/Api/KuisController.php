<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\HasilKuis;
use App\Models\Kuis;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KuisController extends Controller
{
    use ApiResponder;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kuis = Kuis::where('aktif', true)
            ->select('id', 'judul', 'deskripsi', 'batas_waktu')
            ->get();
        return $this->successResponse($kuis, 'List of Kuis retrieved successfully.');
    }
    public function show(string $id)
    {
        $kuis = Kuis::with([
            'pertanyaan.opsipertanyaan' => function ($query) {
                $query->select('id', 'pertanyaan_id', 'jawaban', 'benar');
            },
        ])->select('id', 'judul', 'deskripsi', 'batas_waktu', 'aktif')
            ->findOrFail($id);

        if (! $kuis->aktif) {
            return response()->json([
                'success' => false,
                'message' => 'Kuis tidak aktif',
            ], 403);
        }

        // Format data agar lebih rapi untuk klien
        $formatted = [
            'id'                => $kuis->id,
            'judul'             => $kuis->judul,
            'deskripsi'         => $kuis->deskripsi,
            'batas_waktu'       => $kuis->batas_waktu, // dalam detik
            'jumlah_pertanyaan' => $kuis->pertanyaan->count(),
            'pertanyaan'        => $kuis->pertanyaan->map(function ($p) {
                return [
                    'id'   => $p->id,
                    'teks' => $p->teks_pertanyaan,
                    'poin' => $p->poin,
                    'opsi' => $p->opsipertanyaan->map(function ($opsi) {
                        return [
                            'id'      => $opsi->id,
                            'jawaban' => $opsi->jawaban,
                            // ⚠️ JANGAN kirim 'benar' ke klien saat kuis sedang dikerjakan!
                            // Kita hanya kirim saat review/score, bukan di awal.
                        ];
                    }),
                ];
            }),
        ];

        return $this->successResponse($formatted, 'Kuis retrieved successfully.');

    }
    public function getRandomKuis($tema_id, $limit)
    {
        $kuis = Kuis::where('tema_id', $tema_id)->inRandomOrder()->limit($limit)->get();
        return $this->successResponse($kuis, 'Random Kuis retrieved successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $kuis  = Kuis::where('question', 'LIKE', "%$query%")
            ->orWhere('option_a', 'LIKE', "%$query%")
            ->orWhere('option_b', 'LIKE', "%$query%")
            ->orWhere('option_c', 'LIKE', "%$query%")
            ->orWhere('option_d', 'LIKE', "%$query%")
            ->get();

        return $this->successResponse($kuis, 'Search results retrieved successfully.');
    }

    public function submit(Request $request, string $id)
    {
        $request->validate([
            'device_id' => 'required|string',
            'jawaban'   => 'required|array', // array of [pertanyaan_id => opsi_id]
        ]);

        // Cari atau buat device
        $device = Device::firstOrCreate(
            ['device_id' => $request->device_id],
            ['name' => 'Unknown Device', 'id' => Str::uuid()]
        );

        $kuis           = Kuis::findOrFail($id);
        $pertanyaanList = $kuis->pertanyaan->keyBy('id');

        $total         = count($pertanyaanList);
        $benar         = 0;
        $jawabanDetail = [];

        foreach ($request->jawaban as $pertanyaanId => $opsiId) {
            if (! isset($pertanyaanList[$pertanyaanId])) {
                continue;
            }

            $opsi = \App\Models\OpsiPertanyaan::where('id', $opsiId)
                ->where('pertanyaan_id', $pertanyaanId)
                ->first();

            $isBenar = $opsi ? $opsi->benar : false;
            if ($isBenar) {
                $benar++;
            }

            $jawabanDetail[] = [
                'pertanyaan_id' => $pertanyaanId,
                'opsi_id'       => $opsiId,
                'benar'         => $isBenar,
            ];
        }

        $skor  = $benar; // atau bisa dihitung berdasarkan poin
        $salah = $total - $benar;
        $waktu = $request->input('waktu_pengerjaan', 0); // dalam detik

        // Simpan hasil
        HasilKuis::create([
            'id'               => Str::uuid(),
            'device_id'        => $device->id,
            'kuis_id'          => $kuis->id,
            'skor'             => $skor,
            'total_pertanyaan' => $total,
            'jawaban_benar'    => $benar,
            'jawaban_salah'    => $salah,
            'waktu_pengerjaan' => $waktu,
            'jawaban'          => json_encode($jawabanDetail),
        ]);

        $data = [
            'skor'   => $skor,
            'benar'  => $benar,
            'salah'  => $salah,
            'total'  => $total,
            'detail' => $jawabanDetail,
        ];

        return $this->successResponse($data, 'Kuis submitted successfully.');
    }
}
