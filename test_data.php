<?php
// Script pour générer une intervention de test pour le technicien
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $techId = 1; // Assuming technician ID 1 exists based on previous query

    // Create a dummy client if none exists
    $client = App\Models\Client::first();
    if (!$client) {
        $userId = DB::table('users')->insertGetId([
            'nom' => 'Test',
            'prenom' => 'Client',
            'email' => 'client@test.com',
            'password' => bcrypt('password'),
            'id_role' => 3,
            'tel' => '12345678'
        ]);
        $clientId = DB::table('clients')->insertGetId(['type_clt' => 'Particulier', 'user_id' => $userId]);
    } else {
        $clientId = $client->id;
    }

    $materiel = App\Models\Materiel::where('id_client', $clientId)->first();
    if (!$materiel) {
         $matId = DB::table('materiels')->insertGetId(['nom' => 'Test PC', 'marque' => 'Test', 'modele' => 'Test', 'num_serie' => '1234', 'date_achat' => now(), 'garantie' => '1 an', 'id_client' => $clientId]);
    } else {
        $matId = $materiel->id;
    }

    $ticketId = DB::table('tickets')->insertGetId(['date_creation' => now(), 'description_panne' => 'TEST AUTOMATIQUE : L\'écran ne s\'allume plus.', 'statut' => 'Assigné', 'priorite' => 'Haute', 'id_client' => $clientId, 'id_mat' => $matId, 'created_at' => now(), 'updated_at' => now()]);
    
    $devisId = DB::table('devis')->insertGetId(['date_devis' => now(), 'mont_estimer' => 25000, 'statut' => 'Validé', 'id_ticket' => $ticketId, 'created_at' => now(), 'updated_at' => now()]);
    
    $interventionId = DB::table('interventions')->insertGetId(['date_debut' => now(), 'statut' => 'Planifiée', 'id_tech' => $techId, 'id_devis' => $devisId, 'created_at' => now(), 'updated_at' => now()]);

    echo "Intervention générée avec succès ! ID: " . $interventionId . "\n";
} catch (\Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}
