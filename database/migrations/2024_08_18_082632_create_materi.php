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
        Schema::create('materi', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('cover');
            $table->string('materi');
            $table->string('deskripsi');
            $table->foreignId('id_kategori')->references('id')->on('kategori');
            $table->boolean('lanjutan')->default(false);
            $table->integer('waktu');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('materi_user', function (Blueprint $table) {
            $table->foreignId('id_materi')->references('id')->on('materi');
            $table->foreignId('id_user')->references('id')->on('users');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi_user');
        Schema::dropIfExists('materi');
    }
};
