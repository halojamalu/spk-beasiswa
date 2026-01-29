<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_perhitungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periode_seleksi')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis_proses', ['fuzzy-ahp', 'moora', 'reset']);
            $table->json('detail_proses')->nullable()->comment('JSON data hasil perhitungan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_perhitungan');
    }
};