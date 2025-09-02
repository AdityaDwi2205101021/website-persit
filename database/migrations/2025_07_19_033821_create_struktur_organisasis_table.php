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
        Schema::create('struktur_organisasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable(); // untuk struktur pohon
            $table->string('nama');
            $table->string('jabatan');
            $table->string('foto')->nullable(); // opsional
            $table->timestamps();

            // Relasi foreign key ke dirinya sendiri
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('struktur_organisasis')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_organisasis');
    }
};
