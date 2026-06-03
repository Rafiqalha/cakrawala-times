<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->text('isi_artikel');
            $table->string('gambar', 255)->nullable();
            $table->date('tanggal');
            $table->foreignId('id_penulis')->constrained('penulis')->onDelete('restrict');
            $table->foreignId('id_kategori')->constrained('kategori_artikel')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};
