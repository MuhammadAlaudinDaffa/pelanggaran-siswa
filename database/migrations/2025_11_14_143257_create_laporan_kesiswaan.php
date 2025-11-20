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
        Schema::create('laporan_kesiswaan', function (Blueprint $table) {
            $table->id('laporan_id');
            $table->enum('jenis_data', ['pelanggaran','prestasi']);
            $table->string('tabel_terkait');
            $table->bigInteger('id_data_terkait');
            $table->foreignId('siswa_id')->constrained('siswa', 'siswa_id')->cascadeOnDelete();
            $table->string('tabel_jenis');
            $table->integer('id_data_jenis');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran', 'tahun_ajaran_id')->cascadeOnDelete();
            $table->integer('poin');
            $table->text('keterangan');
            $table->enum('jenis_bukti', ['foto','dokumen'])->nullable();
            $table->string('file_bukti')->nullable();
            $table->date('tanggal');
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kesiswaan');
    }
};
