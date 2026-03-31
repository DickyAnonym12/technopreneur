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
        Schema::create('mitra', function (Blueprint $table) {
            $table->increments('mitra_id');
            $table->string('nama_mitra', 200);
            $table->text('alamat')->nullable();
            $table->string('email', 50)->unique();
            $table->string('nomor_telepon');
            $table->enum('jenis_kemitraan', ['Platinum', 'Gold', 'Silver']);
            $table->date('tanggal_bergabung');
            $table->timestamps();
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitra');
    }
};
