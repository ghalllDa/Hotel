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
        Schema::create('rooms', function (Blueprint $table) {
    $table->id();
    $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
    $table->string('nama_kamar');
    $table->integer('harga');
    $table->string('foto')->nullable();
    $table->json('fasilitas')->nullable(); // kasur, AC, dll
    $table->enum('status', ['tersedia', 'penuh', 'maintenance'])
          ->default('tersedia');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
