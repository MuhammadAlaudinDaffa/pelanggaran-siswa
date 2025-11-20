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
        Schema::create('pembinaan_wali_kelas', function (Blueprint $table) {
            $table->id('pembinaan_wali_kelas_id');
            $table->foreignId('guru_id')->constrained('guru', 'guru_id')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas', 'kelas_id')->cascadeOnDelete();
            $table->enum('prioritas_pesan', ['rendah','sedang','tinggi','penting','darurat'])->default('rendah');
            $table->text('pesan');
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembinaan_wali_kelas');
    }
};
