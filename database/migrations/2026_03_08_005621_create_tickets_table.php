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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->date('date_creation')->useCurrent();
            $table->text('description_panne');
            $table->string('statut', 50)->default('Nouveau');
            $table->string('priorite', 20);
            $table->foreignId('id_client')->constrained('clients');
            $table->foreignId('id_mat')->constrained('materiels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
