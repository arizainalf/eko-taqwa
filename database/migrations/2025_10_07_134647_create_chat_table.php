<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::create('chat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('device_id')->constrained('device')->onDelete('cascade')->onUpdate('cascade');
            $table->text('pesan');
            $table->text('jawaban')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('chat');
    }
};
