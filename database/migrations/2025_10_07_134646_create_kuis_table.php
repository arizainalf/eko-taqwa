<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::create('kuis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->integer('batas_waktu')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('kuis');
    }
};
