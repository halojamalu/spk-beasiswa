<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perbandingan_kriteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periode_seleksi')->onDelete('cascade');
            $table->foreignId('kriteria_1')->constrained('kriteria')->onDelete('cascade');
            $table->foreignId('kriteria_2')->constrained('kriteria')->onDelete('cascade');
            $table->decimal('nilai_crisp', 5, 2)->comment('Nilai 1-9 dari expert');
            $table->decimal('nilai_fuzzy_l', 5, 2)->comment('Lower bound fuzzy triangular');
            $table->decimal('nilai_fuzzy_m', 5, 2)->comment('Middle fuzzy triangular');
            $table->decimal('nilai_fuzzy_u', 5, 2)->comment('Upper bound fuzzy triangular');
            $table->timestamps();
            
            // Unique constraint: satu periode, satu pasangan kriteria hanya bisa dibandingkan sekali
            $table->unique(['periode_id', 'kriteria_1', 'kriteria_2'], 'unique_perbandingan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perbandingan_kriteria');
    }
};