<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Création des Rôles
        DB::table('roles')->insert([
            ['nom_role' => 'Client'],
            ['nom_role' => 'Agent Accueil'],
            ['nom_role' => 'Responsable Maintenance'],
            ['nom_role' => 'Technicien'],
        ]);

        // 2. Création des Utilisateurs types
        // Mots de passe par défaut : 'password'
        $password = Hash::make('password');

        // - Un Agent
        $agentId = DB::table('utilisateurs')->insertGetId([
            'nom' => 'Diallo', 'prenom' => 'Fatou', 
            'email' => 'agent@deviamaint.com', 'tel' => '0102030405', 
            'mot_de_passe' => $password, 'id_role' => 2
        ]);

        // - Un Responsable
        $rmId = DB::table('utilisateurs')->insertGetId([
            'nom' => 'Ndiaye', 'prenom' => 'Ousmane', 
            'email' => 'rm@deviamaint.com', 'tel' => '0607080910', 
            'mot_de_passe' => $password, 'id_role' => 3
        ]);

        // - Un Client
        $clientIdUser = DB::table('utilisateurs')->insertGetId([
            'nom' => 'Dupont', 'prenom' => 'Jean', 
            'email' => 'client@deviamaint.com', 'tel' => '0708091011', 
            'mot_de_passe' => $password, 'id_role' => 1
        ]);

        // - Un Technicien
        $techIdUser = DB::table('utilisateurs')->insertGetId([
            'nom' => 'Martin', 'prenom' => 'Paul', 
            'email' => 'tech@deviamaint.com', 'tel' => '0505050505', 
            'mot_de_passe' => $password, 'id_role' => 4
        ]);

        // 3. Liaison avec les tables spécifiques
        $clientId = DB::table('clients')->insertGetId([
            'adresse_clt' => '10 rue de la Paix, Paris',
            'type_clt' => 'Particulier',
            'user_id' => $clientIdUser
        ]);

        $techId = DB::table('techniciens')->insertGetId([
            'specialite' => 'Matériel Réseau',
            'disponibilite' => true,
            'user_id' => $techIdUser
        ]);

        // 4. Création d'un Matériel pour ce Client
        $matId = DB::table('materiels')->insertGetId([
            'nom' => 'PC Portable Dell',
            'marque' => 'Dell',
            'modele' => 'XPS 15',
            'date_achat' => '2025-01-10',
            'garantie' => '24 mois',
            'id_client' => $clientId
        ]);

        // 5. Création de Pièces pour le catalogue
        DB::table('pieces')->insert([
            ['reference_fabricant' => 'REF-HDD-1TB', 'nom' => 'Disque Dur 1To SATA', 'pu' => 45.50, 'stock_disponible' => 10],
            ['reference_fabricant' => 'REF-RAM-8GB', 'nom' => 'Barrette RAM 8Go DDR4', 'pu' => 30.00, 'stock_disponible' => 20],
            ['reference_fabricant' => 'REF-ECRAN-15', 'nom' => 'Dalle Ecran 15.6 pouces', 'pu' => 85.00, 'stock_disponible' => 5],
            ['reference_fabricant' => 'REF-ALIM-ATX', 'nom' => 'Alimentation 500W', 'pu' => 55.00, 'stock_disponible' => 8],
        ]);
    }
}
