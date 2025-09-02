<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetaWilayahTable extends Migration
{
   public function up()
{
    Schema::create('petas', function (Blueprint $table) {
        $table->id();
        $table->string('cabang');
        $table->decimal('latitude', 10, 7);
        $table->decimal('longitude', 10, 7);
        $table->string('gambar')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('peta_wilayah');
    }
}
