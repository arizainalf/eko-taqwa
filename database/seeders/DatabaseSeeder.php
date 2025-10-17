<?php
namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // ----------------------------
        // FASE
        // ----------------------------
        $faseIds = collect(['A', 'B', 'C'])->map(function ($fase) {
            $id = Str::uuid();
            DB::table('fase')->insert([
                'id'         => $id,
                'nama'       => 'Fase ' . $fase,
                'deskripsi'  => 'Tingkatan pembelajaran fase ' . $fase,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return $id;
        });

        // ----------------------------
        // MAPEL
        // ----------------------------
        $mapelIds = collect(['Ekologi Taqwa', 'KBC', 'Aqidah Akhlak'])->map(function ($mapel) use ($faker) {
            $id = Str::uuid();
            DB::table('mapel')->insert([
                'id'         => $id,
                'nama'       => $mapel,
                'deskripsi'  => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return $id;
        });

        // ----------------------------
        // CP
        // ----------------------------
        foreach ($mapelIds as $i => $mapelId) {
            DB::table('cp')->insert([
                'id'                  => Str::uuid(),
                'fase_id'             => $faseIds[$i],
                'mapel_id'            => $mapelId,
                'metode_pembelajaran' => $faker->randomElement(['rumah', 'sekolah']),
                'nama'                => 'CP untuk ' . $faker->words(2, true),
                'deskripsi'           => $faker->paragraph(),
                'pendekatan'          => $faker->text(75),
                'model'               => $faker->text(75),
                'teknik'              => $faker->text(75),
                'metode'              => $faker->text(75),
                'taktik'              => $faker->text(75),
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        // ----------------------------
        // DEVICE
        // ----------------------------
        $deviceIds = collect(range(1, 5))->map(function ($i) use ($faker) {
            $id = Str::uuid();
            DB::table('device')->insert([
                'id'         => $id,
                'device_id'  => 'DEV-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name'       => $faker->firstName . ' ' . $faker->lastName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return $id;
        });

        DB::table('device')->insert([
            'id'         => Str::uuid(),
            'device_id'  => '123123123',
            'name'       => 'arizainalf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ----------------------------
        // JENIS TEMA & TEMA
        // ----------------------------
        $jenisTemaIds = collect(['Lingkungan', 'Kemanusiaan', 'Teknologi'])->map(function ($tema) use ($faker) {
            $id = Str::uuid();
            DB::table('jenis_tema')->insert([
                'id'         => $id,
                'nama'       => $tema,
                'deskripsi'  => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return $id;
        });

        $temaIds = $jenisTemaIds->flatMap(function ($jenisId) use ($faker) {
            return collect(range(1, 3))->map(function () use ($jenisId, $faker) {
                $id = Str::uuid();
                DB::table('tema')->insert([
                    'id'            => $id,
                    'jenis_tema_id' => $jenisId,
                    'nama'          => ucfirst($faker->word()) . ' Ekologi',
                    'deskripsi'     => $faker->sentence(),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
                return $id;
            });
        });

        // ----------------------------
        // AYAT, HADIST, KAIDAH, KITAB, VIDEO
        // ----------------------------

        foreach ($temaIds as $temaId) {

            DB::table('dalil')->insert([
                'id'         => Str::uuid(),
                'tema_id'    => $temaId,
                'jenis'      => 'ayat',
                'teks_asli'  => 'وَلَا تُفْسِدُوا فِي الْأَرْضِ بَعْدَ إِصْلَاحِهَا ۚ ذَٰلِكُمْ خَيْرٌ لَّكُمْ إِن كُنتُم مُّؤْمِنِينَ',
                'terjemahan' => 'Dan janganlah kamu membuat kerusakan di muka
                bumi setelah Allah memperbaikinya. Itu lebih baik bagimu jika kamu orang-orang yang beriman.',
                'sumber'     => 'QS. Al-A’raf: 56',
                'penjelasan' => 'Pentingnya menjaga kelestarian alam.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('kaidah')->insert([
                'id'           => Str::uuid(),
                'tema_id'      => $temaId,
                'jenis_kaidah' => 'fiqhiyah',
                'kaidah'       => 'المَضَرَّةُ تُزَالُ',
                'kaidah_latin' => 'Al-madharratu tuzaal',
                'terjemahan'   => 'Kemudharatan harus dihilangkan.',
                'deskripsi'    => 'Prinsip dalam fiqh yang menekankan pentingnya menghilangkan bahaya atau mudharat demi kebaikan umat.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            DB::table('video')->insert([
                'id'         => Str::uuid(),
                'tema_id'    => $temaId,
                'judul'      => 'Video ' . $faker->words(2, true),
                'deskripsi'  => $faker->sentence(),
                'link'       => 'https://youtu.be/' . Str::random(8),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ----------------------------
        // KUIS, PERTANYAAN, OPSI
        // ----------------------------
        $kuisIds = collect(range(1, 20))->map(function ($i) use ($faker) {
            $id = Str::uuid();
            DB::table('kuis')->insert([
                'id'          => $id,
                'judul'       => 'Kuis Ekologi #' . $i,
                'deskripsi'   => $faker->sentence(),
                'batas_waktu' => rand(180, 600),
                'aktif'       => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // 10 pertanyaan per kuis
            for ($q = 1; $q <= 10; $q++) {
                $pertanyaanId = Str::uuid();
                DB::table('pertanyaan')->insert([
                    'id'              => $pertanyaanId,
                    'kuis_id'         => $id,
                    'teks_pertanyaan' => $faker->sentence() . '?',
                    'poin'            => rand(1, 5),
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);

                // 4 opsi per pertanyaan
                $benarIndex = rand(1, 4);
                for ($j = 1; $j <= 4; $j++) {
                    DB::table('opsi_pertanyaan')->insert([
                        'id'            => Str::uuid(),
                        'pertanyaan_id' => $pertanyaanId,
                        'jawaban'       => $faker->words(3, true),
                        'benar'         => $j === $benarIndex,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);
                }
            }

            return $id;
        });

        // ----------------------------
        // HASIL KUIS, REFLEKSI, CHAT
        // ----------------------------
        foreach ($deviceIds as $deviceId) {
            foreach ($kuisIds->random(5) as $kuisId) {
                DB::table('hasil_kuis')->insert([
                    'id'               => Str::uuid(),
                    'device_id'        => $deviceId,
                    'kuis_id'          => $kuisId,
                    'skor'             => rand(5, 10),
                    'total_pertanyaan' => 10,
                    'jawaban_benar'    => rand(5, 10),
                    'jawaban_salah'    => rand(0, 5),
                    'waktu_pengerjaan' => rand(200, 600),
                    'jawaban'          => json_encode(['1' => 'A', '2' => 'C']),
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }

            DB::table('refleksi')->insert([
                'id'         => Str::uuid(),
                'device_id'  => $deviceId,
                'gambar'     => null,
                'judul'      => 'Refleksi ' . $faker->words(2, true),
                'deskripsi'  => $faker->paragraph(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('chat')->insert([
                'id'         => Str::uuid(),
                'device_id'  => $deviceId,
                'pesan'      => $faker->sentence() . '?',
                'jawaban'    => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        echo "✅ Seeder selesai: data besar berhasil dibuat!\n";
    }
}
