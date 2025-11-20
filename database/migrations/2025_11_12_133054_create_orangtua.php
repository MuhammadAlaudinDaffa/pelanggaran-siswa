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
        Schema::create('orangtua', function (Blueprint $table) {
            $table->id('orangtua_id');
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id')->nullOnDelete();
            $table->foreignId('siswa_id')->nullable()->constrained('siswa', 'siswa_id')->nullOnDelete();
            $table->enum('hubungan', ['ayah', 'ibu', 'wali']);
            $table->string('nama_orangtua');
            $table->string('pekerjaan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('no_telp');
            $table->string('alamat')->nullable();
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orangtua');
    }
};
