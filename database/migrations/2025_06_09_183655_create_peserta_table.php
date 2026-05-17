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
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('id_rfid')->unique();
            $table->string('nama');
            $table->string('asal_delegasi');
            $table->enum('komisi', ['organisasi', 'program-kerja', 'rekomendasi']);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']); // kolom jenis kelamin ditambahkan di sini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};
