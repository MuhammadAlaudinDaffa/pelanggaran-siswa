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
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusan', 'jurusan_id')->nullOnDelete();
            $table->integer('kapasitas')->nullable();
            $table->foreignId('wali_kelas_id')->nullable()->constrained('guru', 'guru_id')->nullOnDelete();
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
