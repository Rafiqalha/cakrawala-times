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
        Schema::create('reaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artikel_id')->constrained('artikel')->onDelete('cascade');
            $table->string('tipe_reaksi'); // inspiratif, terkejut, sedih, menarik
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reaksis');
    }
};
