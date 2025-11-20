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
        Schema::create('pelaksanaan_sanksi', function (Blueprint $table) {
            $table->id('pelaksanaan_id');
            $table->foreignId('sanksi_id')->nullable()->constrained('sanksi', 'sanksi_id')->nullOnDelete();
            $table->date('tanggal_pelaksanaan');
            $table->text('deskripsi_pelaksanaan')->nullable();
            $table->string('bukti_pelaksanaan')->nullable();
            $table->enum('status', ['terjadwal','dikerjakan','tuntas','terlambat','perpanjangan'])->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('guru_pengawas')->nullable()->constrained('guru', 'guru_id')->nullOnDelete();
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaksanaan_sanksi');
    }
};
