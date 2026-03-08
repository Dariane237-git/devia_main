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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->integer('temps_passe_minute')->nullable();
            $table->string('statut', 50)->default('Planifiée');
            $table->text('rapport_technn')->nullable();
            $table->foreignId('id_devis')->unique()->constrained('devis');
            $table->foreignId('id_tech')->constrained('techniciens');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
