<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::create('tema', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('jenis_tema_id')->constrained('jenis_tema');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('tema');
    }
};
