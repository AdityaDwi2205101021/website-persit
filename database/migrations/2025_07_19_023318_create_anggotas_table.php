<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id();

            $table->string('nama');                          // Nama lengkap
            $table->string('tempat_lahir')->nullable();      // Tempat lahir
            $table->date('tanggal_lahir')->nullable();       // Tanggal lahir
            $table->string('pendidikan_terakhir');           // Pendidikan terakhir (dropdown)
            $table->string('jurusan')->nullable();           // Jurusan dari pendidikan terakhir
            $table->string('nama_suami')->nullable();        // Nama suami
            $table->string('pangkat_nrp')->nullable();       // Pangkat/NRP
            $table->integer('jumlah_anak')->nullable();      // Jumlah anak (integer)
            $table->string('pekerjaan')->nullable();         // Pekerjaan
            $table->date('tanggal_menikah')->nullable();     // Tanggal menikah
            $table->text('alamat')->nullable();               // Alamat/tempat tinggal
            $table->text('keterangan')->nullable();           // Keterangan tambahan
            $table->string('foto')->nullable();                // Foto anggota (optional)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
