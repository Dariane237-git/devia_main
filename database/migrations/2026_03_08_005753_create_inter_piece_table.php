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
        Schema::create('inter_piece', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_int')->constrained('interventions')->onDelete('cascade');
            $table->foreignId('id_piece')->constrained('pieces')->onDelete('cascade');
            $table->integer('qte_reel_utiliser');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inter_piece');
    }
};
