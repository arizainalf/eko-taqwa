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
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('My App');
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->boolean('maintenance_mode')->default(false);
            $table->string('logo_path')->nullable(); // untuk upload gambar
            $table->timestamps();
        });

        $settings = [
            'site_name'        => 'My App',
            'email'            => 'admin@gmail.com',
            'description'      => 'Welcome to our app!',
            'maintenance_mode' => false,
        ];

        DB::table('pengaturan')->insert($settings);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
