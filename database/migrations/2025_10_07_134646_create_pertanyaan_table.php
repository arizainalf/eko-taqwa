<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kuis_id')->constrained('kuis');
            $table->text('teks_pertanyaan');
            $table->integer('poin')->default(1);
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('pertanyaan');
    }
};
