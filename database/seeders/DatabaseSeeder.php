<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---- FASE ----
        $faseAId = Str::uuid();
        $faseBId = Str::uuid();

        DB::table('fase')->insert([
            ['id' => $faseAId, 'nama' => 'Fase A', 'deskripsi' => 'Untuk kelas 1–2 SD', 'created_at' => now(), 'updated_at' => now()],
            ['id' => $faseBId, 'nama' => 'Fase B', 'deskripsi' => 'Untuk kelas 3–4 SD', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ---- MAPEL ----
        $mapelId = Str::uuid();
        DB::table('mapel')->insert([
            ['id' => $mapelId, 'nama' => 'Ekologi Taqwa', 'deskripsi' => 'Pelajaran berbasis cinta dan ekologi takwa.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ---- CP ----
        $cpId = Str::uuid();
        DB::table('cp')->insert([
            [
                'id' => $cpId,
                'fase_id' => $faseAId,
                'mapel_id' => $mapelId,
                'deskripsi' => 'Peserta didik mampu menerapkan nilai ekologi dalam kehidupan sehari-hari.',
                'pendekatan' => 'Saintifik',
                'model' => 'Project Based Learning',
                'teknik' => 'Diskusi reflektif',
                'metode' => 'Observasi lapangan',
                'taktik' => 'Kolaboratif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---- DEVICE ----
        $deviceId = Str::uuid();
        DB::table('device')->insert([
            ['id' => $deviceId, 'device_id' => 'DEV-001', 'name' => 'Tablet Siswa 1', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ---- JENIS TEMA ----
        $jenisTemaId = Str::uuid();
        DB::table('jenis_tema')->insert([
            ['id' => $jenisTemaId, 'nama' => 'Lingkungan', 'deskripsi' => 'Tema tentang alam dan kelestarian lingkungan.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ---- TEMA ----
        $temaId = Str::uuid();
        DB::table('tema')->insert([
            ['id' => $temaId, 'jenis_tema_id' => $jenisTemaId, 'nama' => 'Ekologi Cinta', 'deskripsi' => 'Menumbuhkan rasa cinta terhadap alam.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ---- AYAT ----
        DB::table('ayat')->insert([
            [
                'id' => Str::uuid(),
                'tema_id' => $temaId,
                'ayat' => 'Dan janganlah kamu membuat kerusakan di muka bumi setelah (Allah) memperbaikinya. (QS. Al-A’raf: 56)',
                'terjemahan' => 'Larangan berbuat kerusakan di bumi.',
                'penjelasan' => 'Ayat ini menegaskan pentingnya menjaga kelestarian alam.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---- HADIST ----
        DB::table('hadist')->insert([
            [
                'id' => Str::uuid(),
                'tema_id' => $temaId,
                'hadist' => 'Kebersihan adalah sebagian dari iman.',
                'terjemahan' => 'Menjaga kebersihan merupakan bagian dari keimanan.',
                'penjelasan' => 'Hadist ini mengajarkan nilai kebersihan dan tanggung jawab lingkungan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---- JENIS KAIDAH ----
        $jenisKaidahId = Str::uuid();
        DB::table('jenis_kaidah')->insert([
            ['id' => $jenisKaidahId, 'nama' => 'Kaidah Fiqhiyah', 'deskripsi' => 'Prinsip dasar dalam hukum Islam.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ---- KAIDAH ----
        DB::table('kaidah')->insert([
            [
                'id' => Str::uuid(),
                'tema_id' => $temaId,
                'jenis_kaidah_id' => $jenisKaidahId,
                'deskripsi' => 'Kemudharatan harus dihilangkan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---- KITAB ----
        DB::table('kitab')->insert([
            [
                'id' => Str::uuid(),
                'tema_id' => $temaId,
                'kitab' => 'Kitab Al-Bughayah',
                'penjelasan' => 'Membahas hubungan manusia dengan alam dan etika ekologis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---- VIDEO ----
        DB::table('video')->insert([
            [
                'id' => Str::uuid(),
                'tema_id' => $temaId,
                'judul' => 'Ekologi Taqwa',
                'deskripsi' => 'Video edukasi tentang cinta lingkungan.',
                'link' => 'https://youtu.be/ekologi-taqwa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---- KUIS ----
        $kuisId = Str::uuid();
        DB::table('kuis')->insert([
            [
                'id' => $kuisId,
                'judul' => 'Kuis Ekologi Taqwa',
                'deskripsi' => 'Uji pemahaman tentang ekologi takwa.',
                'batas_waktu' => 300,
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---- PERTANYAAN ----
        $pertanyaanId = Str::uuid();
        DB::table('pertanyaan')->insert([
            [
                'id' => $pertanyaanId,
                'kuis_id' => $kuisId,
                'teks_pertanyaan' => 'Apa arti ekologi dalam Islam?',
                'poin' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---- OPSI PERTANYAAN ----
        DB::table('opsi_pertanyaan')->insert([
            [
                'id' => Str::uuid(),
                'pertanyaan_id' => $pertanyaanId,
                'jawaban' => 'Hubungan manusia dengan alam berdasarkan nilai takwa',
                'benar' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'pertanyaan_id' => $pertanyaanId,
                'jawaban' => 'Pemanfaatan alam tanpa batas',
                'benar' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---- HASIL KUIS ----
        DB::table('hasil_kuis')->insert([
            [
                'id' => Str::uuid(),
                'device_id' => $deviceId,
                'kuis_id' => $kuisId,
                'skor' => 10,
                'total_pertanyaan' => 1,
                'jawaban_benar' => 1,
                'jawaban_salah' => 0,
                'waktu_pengerjaan' => 120,
                'jawaban' => json_encode(['1' => 'A']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---- REFLEKSI ----
        DB::table('refleksi')->insert([
            [
                'id' => Str::uuid(),
                'device_id' => $deviceId,
                'gambar' => null,
                'judul' => 'Menjaga Kebersihan Lingkungan',
                'deskripsi' => 'Saya belajar bahwa menjaga kebersihan adalah ibadah.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ---- CHAT ----
        DB::table('chat')->insert([
            [
                'id' => Str::uuid(),
                'device_id' => $deviceId,
                'pesan' => 'Apa itu ekologi takwa?',
                'jawaban' => 'Ekologi takwa adalah pendekatan cinta lingkungan dengan nilai ketuhanan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
