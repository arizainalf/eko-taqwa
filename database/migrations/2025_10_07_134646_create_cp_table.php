<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::create('cp', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fase_id')->constrained('fase');
            $table->foreignUuid('mapel_id')->constrained('mapel');
            $table->enum('metode_pembelajaran', ['rumah', 'sekolah'])->default('sekolah');
            $table->string('nama');
            $table->text('deskripsi');
            $table->text('pendekatan')->nullable();
            $table->text('model')->nullable();
            $table->text('teknik')->nullable();
            $table->text('metode')->nullable();
            $table->text('taktik')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('cp');
    }
};
