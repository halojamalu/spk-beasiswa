<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_perhitungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periode_seleksi')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->decimal('nilai_moora', 10, 6)->comment('Nilai Yi dari MOORA');
            $table->integer('ranking');
            $table->enum('status_penerima', ['layak', 'tidak_layak', 'cadangan'])->default('tidak_layak');
            $table->timestamps();
            
            // Unique constraint: satu siswa di satu periode hanya punya satu hasil
            $table->unique(['periode_id', 'siswa_id'], 'unique_hasil');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_perhitungan');
    }
};