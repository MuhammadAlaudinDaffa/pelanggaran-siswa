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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('kelas_id');
            $table->string('nama_kelas');
            $table->foreignId('jurusan_id')->constrained('jurusan', 'jurusan_id')->cascadeOnDelete();
            $table->integer('kapasitas')->nullable();
            $table->foreignId('wali_kelas_id')->constrained('guru', 'guru_id')->cascadeOnDelete();
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
