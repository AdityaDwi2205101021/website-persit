<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrukturCabangTable extends Migration
{
    public function up(): void
    {
        Schema::create('struktur_cabang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('cabang');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();

            // foreign key ke id sendiri (struktur_cabang)
            $table->foreign('parent_id')->references('id')->on('struktur_cabang')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('struktur_cabang', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
        Schema::dropIfExists('struktur_cabang');
    }
}
