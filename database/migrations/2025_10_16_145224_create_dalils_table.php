<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dalil', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tema_id')->constrained('tema')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('jenis', ['ayat', 'hadist']);
            $table->text('teks_asli');
            $table->text('terjemahan')->nullable();
            $table->text('sumber')->nullable();
            $table->text('penjelasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dalil');
    }
};
