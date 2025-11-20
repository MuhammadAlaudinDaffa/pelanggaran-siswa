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
        Schema::create('bimbingan_konseling', function (Blueprint $table) {
            $table->id('bk_id');
            $table->foreignId('siswa_id')->constrained('siswa', 'siswa_id')->cascadeOnDelete();
            $table->foreignId('guru_konselor')->nullable()->constrained('guru', 'guru_id')->cascadeOnDelete();
            $table->foreignId('konselor_user_id')->nullable()->constrained('users', 'user_id')->cascadeOnDelete();
            $table->string('konselor_tim')->nullable();
            $table->unsignedBigInteger('bk_parent_id')->nullable();
            $table->integer('child_count')->default(0);
            $table->integer('child_order')->default(0);
            $table->foreignId('tahun_ajaran_id')->nullable()->constrained('tahun_ajaran', 'tahun_ajaran_id')->nullOnDelete();
            $table->enum('jenis_layanan', ['pribadi','sosial','belajar','karir'])->nullable();
            $table->string('topik')->nullable();
            $table->text('keluhan_masalah')->nullable();
            $table->text('tindakan_solusi')->nullable();
            $table->enum('status', ['menunggu','berkelanjutan','tindak_lanjut','selesai','ditolak'])->default('menunggu');
            $table->date('tanggal_konseling')->nullable(); 
            $table->date('tanggal_tindak_lanjut')->nullable();
            $table->string('hasil_evaluasi')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbingan_konseling');
    }
};
