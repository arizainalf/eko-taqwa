<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::create('hasil_kuis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('device_id')->constrained('device');
            $table->foreignUuid('kuis_id')->constrained('kuis');
            $table->integer('skor');
            $table->integer('total_pertanyaan');
            $table->integer('jawaban_benar');
            $table->integer('jawaban_salah');
            $table->integer('waktu_pengerjaan');
            $table->json('jawaban')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('hasil_kuis');
    }
};
