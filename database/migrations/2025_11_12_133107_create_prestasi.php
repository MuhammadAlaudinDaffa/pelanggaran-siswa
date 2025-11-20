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
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id('prestasi_id');
            $table->foreignId('siswa_id')->nullable()->constrained('siswa', 'siswa_id')->nullOnDelete();
            $table->foreignId('guru_pencatat')->nullable()->constrained('guru', 'guru_id')->nullOnDelete();
            $table->foreignId('user_pencatat')->nullable()->constrained('users', 'user_id')->nullOnDelete();
            $table->foreignId('jenis_prestasi_id')->nullable()->constrained('jenis_prestasi', 'jenis_prestasi_id')->nullOnDelete();
            $table->foreignId('tahun_ajaran_id')->nullable()->constrained('tahun_ajaran', 'tahun_ajaran_id')->nullOnDelete();
            $table->integer('poin');
            $table->string('keterangan')->nullable();
            $table->enum('tingkat', ['kecamatan','provinsi','nasional'])->nullable();
            $table->string('penghargaan')->nullable();
            $table->string('bukti_dokumen')->nullable();
            $table->enum('status_verifikasi', ['menunggu','diverifikasi','ditolak','revisi'])->default('menunggu');
            $table->foreignId('guru_verifikator')->nullable()->constrained('guru', 'guru_id')->nullOnDelete();
            $table->string('verifikator_tim')->nullable();
            $table->text('catatan_verifikasi')->nullable();
            $table->date('tanggal')->nullable();
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};
