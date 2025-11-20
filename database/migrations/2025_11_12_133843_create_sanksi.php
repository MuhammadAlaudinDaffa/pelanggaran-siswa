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
        Schema::create('sanksi', function (Blueprint $table) {
            $table->id('sanksi_id');
            $table->foreignId('pelanggaran_id')->nullable()->constrained('pelanggaran', 'pelanggaran_id')->nullOnDelete();
            $table->string('jenis_sanksi');
            $table->text('deskripsi_sanksi')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['direncanakan','berjalan','selesai','ditunda','dibatalkan'])->default('direncanakan');
            $table->text('catatan_pelaksanaan')->nullable();
            $table->foreignId('guru_penanggungjawab')->nullable()->constrained('guru', 'guru_id')->nullOnDelete();
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanksi');
    }
};
