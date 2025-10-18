<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::create('refleksi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('device_id')->constrained('device');
            $table->string('gambar')->nullable();
            $table->text('judul');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal')->default(now());
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('refleksi');
    }
};
