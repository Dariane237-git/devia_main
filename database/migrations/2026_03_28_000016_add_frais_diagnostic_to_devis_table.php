<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajout des frais de diagnostic (applicable si le client refuse le devis).
     */
    public function up(): void
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->decimal('frais_diagnostic', 10, 2)->nullable()->default(0)->after('mont_estimer');
        });
    }

    public function down(): void
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->dropColumn('frais_diagnostic');
        });
    }
};
