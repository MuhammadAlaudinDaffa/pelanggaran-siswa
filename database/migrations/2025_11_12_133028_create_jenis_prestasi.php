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
        Schema::create('jenis_prestasi', function (Blueprint $table) {
            $table->id('jenis_prestasi_id');
            $table->string('nama_prestasi');
            $table->integer('poin');
            $table->foreignId('kategori_prestasi_id')->nullable()->constrained('kategori_prestasi', 'kategori_prestasi_id')->nullOnDelete();
            $table->text('deskripsi')->nullable();
            $table->string('reward')->nullable();
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_prestasi');
    }
};
