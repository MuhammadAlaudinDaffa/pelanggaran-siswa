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
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->id('pelanggaran_id');
            $table->foreignId('siswa_id')->constrained('siswa', 'siswa_id')->cascadeOnDelete();
            $table->foreignId('guru_pencatat')->constrained('guru', 'guru_id')->cascadeOnDelete();
            $table->foreignId('jenis_pelanggaran_id')->constrained('jenis_pelanggaran', 'jenis_pelanggaran_id')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran', 'tahun_ajaran_id')->cascadeOnDelete();
            $table->integer('poin');
            $table->string('keterangan')->nullable();
            $table->string('bukti_foto')->nullable();
            $table->enum('status_verifikasi', ['menunggu','diverifikasi','tolak','revisi'])->default('menunggu');
            $table->foreignId('guru_verifikator')->nullable()->constrained('guru', 'guru_id')->cascadeOnDelete();
            $table->string('verifikator_tim')->nullable();
            $table->string('catatan_verifikasi')->nullable();
            $table->date('tanggal')->nullable();
            $table->dateTime('created_at')->useCurrent();
        });
    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggaran');
    }
};
