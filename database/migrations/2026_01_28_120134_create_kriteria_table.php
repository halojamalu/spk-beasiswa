<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kriteria', 10)->unique()->comment('C1, C2, C3, dst');
            $table->string('nama_kriteria', 100);
            $table->enum('jenis', ['benefit', 'cost'])->default('benefit');
            $table->decimal('bobot', 5, 4)->default(0)->comment('Hasil dari Fuzzy-AHP');
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kriteria');
    }
};