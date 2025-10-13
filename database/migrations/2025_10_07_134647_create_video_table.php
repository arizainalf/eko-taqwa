<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::create('video', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tema_id')->constrained('tema');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('link');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('video');
    }
};
