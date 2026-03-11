<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * Creates an Utilisateur (with role Client = id_role 1)
     * and the associated Client profile.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // ── Validation de tous les champs ──
        $request->validate([
            // Champs table utilisateurs
            'nom'      => ['required', 'string', 'max:100'],
            'prenom'   => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:' . Utilisateur::class],
            'tel'      => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Champs table clients
            'type_clt'    => ['required', 'string', 'in:Particulier,Entreprise'],
            'adresse_clt' => ['nullable', 'string', 'max:255'],
        ]);

        // ── Création de l'utilisateur ──
        $user = Utilisateur::create([
            'nom'          => $request->nom,
            'prenom'       => $request->prenom,
            'email'        => $request->email,
            'tel'          => $request->tel,
            'mot_de_passe' => Hash::make($request->password),
            'id_role'      => 1, // Rôle Client (enregistré par défaut)
        ]);

        // ── Création du profil client associé ──
        Client::create([
            'user_id'     => $user->id,
            'type_clt'    => $request->type_clt,
            'adresse_clt' => $request->adresse_clt,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
