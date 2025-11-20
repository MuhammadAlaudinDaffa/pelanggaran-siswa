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
        Schema::create('jenis_pelanggaran', function (Blueprint $table) {
            $table->id('jenis_pelanggaran_id');
            $table->string('nama_pelanggaran');
            $table->integer('poin');
            $table->foreignid('kategori_pelanggaran_id')->nullable()->constrained('kategori_pelanggaran', 'kategori_pelanggaran_id')->nullOnDelete();
            $table->text('deskripsi')->nullable();
            $table->string('sanksi_rekomendasi')->nullable();
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_pelanggaran');
    }
};
