<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::create('kaidah', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tema_id')->constrained('tema');
            $table->foreignUuid('jenis_kaidah_id')->constrained('jenis_kaidah');
            $table->text('deskripsi');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('kaidah');
    }
};
