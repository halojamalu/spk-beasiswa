<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 20)->unique();
            $table->string('nama_lengkap', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('kelas', 10);
            $table->text('alamat')->nullable();
            $table->string('nama_ortu', 100)->nullable();
            $table->string('pekerjaan_ortu', 100)->nullable();
            $table->decimal('penghasilan_ortu', 12, 2)->default(0);
            $table->integer('jumlah_tanggungan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};