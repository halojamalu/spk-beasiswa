<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periode_seleksi')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriteria')->onDelete('cascade');
            $table->decimal('nilai', 10, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            // Unique constraint: satu siswa di satu periode untuk satu kriteria hanya punya satu nilai
            $table->unique(['periode_id', 'siswa_id', 'kriteria_id'], 'unique_penilaian');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_siswa');
    }
};