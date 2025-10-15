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
        Schema::table('cp', function (Blueprint $table) {
            $table->string('nama')->after('mapel_id');
            $table->text('pendekatan')->change()->nullable();
            $table->text('model')->change()->nullable();
            $table->text('teknik')->change()->nullable();
            $table->text('metode')->change()->nullable();
            $table->text('taktik')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cp', function (Blueprint $table) {
            $table->dropColumn('nama');
            $table->string('pendekatan')->nullable();
            $table->string('model')->nullable();
            $table->string('teknik')->nullable();
            $table->string('metode')->nullable();
            $table->string('taktik')->nullable();
        });
    }
};
