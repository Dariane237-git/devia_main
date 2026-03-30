<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Client;
use Illuminate\Http\Request;

class MaterielController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer tous les matériels avec le client associé
        $materiels = Materiel::with('client.utilisateur')->orderBy('created_at', 'desc')->get();
        return view('materiels.index', compact('materiels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer tous les clients pour le menu déroulant
        $clients = Client::with('utilisateur')->get();
        return view('materiels.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_client' => 'required|exists:clients,id',
            'nom' => 'required|string|max:255',
            'marque' => 'nullable|string|max:255',
            'modele' => 'nullable|string|max:255',
            'date_achat' => 'nullable|date',
            'garantie' => 'nullable|string|max:255',
        ]);

        Materiel::create($request->all());

        return redirect()->route('materiels.index')->with('success', 'Le matériel a été enregistré avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materiel $materiel)
    {
        $clients = Client::with('utilisateur')->get();
        return view('materiels.edit', compact('materiel', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materiel $materiel)
    {
        $request->validate([
            'id_client' => 'required|exists:clients,id',
            'nom' => 'required|string|max:255',
            'marque' => 'nullable|string|max:255',
            'modele' => 'nullable|string|max:255',
            'date_achat' => 'nullable|date',
            'garantie' => 'nullable|string|max:255',
        ]);

        $materiel->update($request->all());

        return redirect()->route('materiels.index')->with('success', 'Le matériel a été mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materiel $materiel)
    {
        $materiel->delete();
        return redirect()->route('materiels.index')->with('success', 'Le matériel a été supprimé.');
    }

    /**
     * Retourne les matériels d'un client au format JSON (pour formulaire AJAX).
     */
    public function getByClient($id_client)
    {
        $materiels = Materiel::where('id_client', $id_client)->get();
        return response()->json($materiels);
    }
}
