<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('jumlah_tamu');
            $table->string('nama_pemesan');
            $table->string('no_hp');
            $table->text('catatan')->nullable();
            $table->bigInteger('total_harga');
            $table->string('status')->default('pending'); // pending, paid, canceled, completed
            $table->string('transaction_id')->nullable(); // dari Midtrans
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};