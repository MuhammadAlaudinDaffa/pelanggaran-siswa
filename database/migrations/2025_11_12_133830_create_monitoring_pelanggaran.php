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
        Schema::create('monitoring_pelanggaran', function (Blueprint $table) {
            $table->id('monitoring_id');
            $table->foreignId('pelanggaran_id')->constrained('pelanggaran', 'pelanggaran_id')->cascadeOnDelete();
            $table->foreignId('guru_kepsek_id')->constrained('guru', 'guru_id')->cascadeOnDelete();
            $table->enum('status_monitoring', ['dipantau','tindak_lanjut','progres_baik','selesai','eskalasi'])->default('dipantau');
            $table->text('catatan_monitoring')->nullable();
            $table->date('tanggal_monitoring');
            $table->string('tindak_lanjut')->nullable();
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_pelanggaran');
    }
};
