<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('Rantings', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable(); // path foto
            $table->date('tanggal_terakhir_diubah')->nullable(); // tanggal terakhir diubah
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('Rantings');
    }
};
