<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Role;
use App\Models\Client;
use App\Models\Technicien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les utilisateurs avec leur rôle
        $users = Utilisateur::with('role')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation globale
        $request->validate([
            'nom'      => ['required', 'string', 'max:100'],
            'prenom'   => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'email', 'max:150', 'unique:' . Utilisateur::class],
            'tel'      => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'id_role'  => ['required', 'exists:roles,id'],
            // Champs spécifiques Client
            'type_clt'    => ['nullable', 'string', 'in:Particulier,Entreprise', 'required_if:id_role,1'],
            'adresse_clt' => ['nullable', 'string', 'max:255'],
            // Champs spécifiques Technicien
            'specialite' => ['nullable', 'string', 'max:150'],
        ]);

        // Création Utilisateur
        $user = Utilisateur::create([
            'nom'          => $request->nom,
            'prenom'       => $request->prenom,
            'email'        => $request->email,
            'tel'          => $request->tel,
            'mot_de_passe' => Hash::make($request->password),
            'id_role'      => $request->id_role,
        ]);

        // Si c'est un Client (id_role = 1)
        if ($request->id_role == 1) {
            Client::create([
                'user_id'     => $user->id,
                'type_clt'    => $request->type_clt,
                'adresse_clt' => $request->adresse_clt,
            ]);
        }
        
        // Si c'est un Technicien (id_role = 3)
        if ($request->id_role == 3) {
            Technicien::create([
                'user_id'     => $user->id,
                'specialite'  => $request->specialite,
                'disponibilite' => true,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // View user profile (Optional, often skipped if edit view is enough)
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Utilisateur::with(['client', 'technicien'])->findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Utilisateur::findOrFail($id);

        $request->validate([
            'nom'      => ['required', 'string', 'max:100'],
            'prenom'   => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'email', 'max:150', 'unique:utilisateurs,email,' . $user->id],
            'tel'      => ['nullable', 'string', 'max:20'],
            'id_role'  => ['required', 'exists:roles,id'],
            // Champs spécifiques Client
            'type_clt'    => ['nullable', 'string', 'in:Particulier,Entreprise', 'required_if:id_role,1'],
            'adresse_clt' => ['nullable', 'string', 'max:255'],
            // Champs spécifiques Technicien
            'specialite' => ['nullable', 'string', 'max:150'],
        ]);

        $user->update([
            'nom'      => $request->nom,
            'prenom'   => $request->prenom,
            'email'    => $request->email,
            'tel'      => $request->tel,
            'id_role'  => $request->id_role,
        ]);

        // Optionnel : Mise à jour du mot de passe
        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Rules\Password::defaults()]]);
            $user->update(['mot_de_passe' => Hash::make($request->password)]);
        }

        // --- Synchronisation Profils ---
        
        // Si ancien rôle était Client (1) et nouveau rôle est différent, on supprime le profil Client
        if ($user->id_role != 1 && $user->client) {
            $user->client()->delete();
        }
        // Si nouveau rôle est Client (1)
        if ($request->id_role == 1) {
            Client::updateOrCreate(
                ['user_id' => $user->id],
                ['type_clt' => $request->type_clt, 'adresse_clt' => $request->adresse_clt]
            );
        }

        // Si ancien rôle était Technicien (4) et nouveau rôle différent
        if ($user->id_role != 4 && $user->technicien) {
            $user->technicien()->delete();
        }
        // Si nouveau rôle est Technicien (4)
        if ($request->id_role == 4) {
            Technicien::updateOrCreate(
                ['user_id' => $user->id],
                ['specialite' => $request->specialite]
            );
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Utilisateur::findOrFail($id);
        
        // Note: S'il existe des contraintes de clés étrangères (ex: des tickets liés au technicien / client),
        // il faut soit gérer Cascade Delete via DB, soit vérifier ici avant de supprimer !
        // Pour DEVIA-MAINT on suppose OnDelete('cascade') défini dans les migrations.

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }
}
