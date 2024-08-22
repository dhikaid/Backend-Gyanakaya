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
        Schema::create('modul', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('cover');
            $table->string('modul');
            $table->foreignId('id_materi')->references('id')->on('materi');
            $table->text('detail');
            $table->timestamps();
        });

        Schema::create('modul_user', function (Blueprint $table) {
            $table->foreignId('id_modul')->references('id')->on('modul');
            $table->foreignId('id_user')->references('id')->on('users');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_user');
        Schema::dropIfExists('modul');
    }
};
