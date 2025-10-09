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
            $table->text('deskripsi');
            $table->string('pendekatan')->nullable();
            $table->string('model')->nullable();
            $table->string('teknik')->nullable();
            $table->string('metode')->nullable();
            $table->string('taktik')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('cp');
    }
};
