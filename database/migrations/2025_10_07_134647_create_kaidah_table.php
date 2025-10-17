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
            $table->enum('jenis_kaidah', ['ushuliyah', 'fiqhiyah']);
            $table->text('kaidah');
            $table->text('kaidah_latin')->nullable();
            $table->text('terjemahan')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('kaidah');
    }
};
