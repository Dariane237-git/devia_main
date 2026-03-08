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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('numero_fac', 50)->unique();
            $table->dateTime('date_emission');
            $table->decimal('mont_total', 10, 2);
            $table->string('type_fac', 50);
            $table->string('statut_paiement', 50)->default('En attente');
            $table->foreignId('id_devis')->unique()->constrained('devis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
