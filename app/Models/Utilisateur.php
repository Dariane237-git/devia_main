<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;
    // Les attributs que l'on peut assigner en masse
    protected $fillable = ['nom', 'prenom', 'email', 'tel', 'mot_de_passe', 'id_role'];

    // Les attributs cachés lors de la sérialisation (ex: envoi en JSON)
    protected $hidden = ['mot_de_passe'];

    /**
     * Surcharge pour Laravel Auth : le mot de passe s'appelle 'mot_de_passe' et non 'password'
     */
    public function getAuthPasswordName(): string
    {
        return 'mot_de_passe';
    }

    /**
     * Retourne la valeur hashée du mot de passe pour Laravel Auth.
     */
    public function getAuthPassword(): string
    {
        return $this->mot_de_passe;
    }

    /**
     * Un utilisateur possède un seul rôle.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    /**
     * Un utilisateur peut être lié à un profil Client.
     */
    public function client()
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    /**
     * Un utilisateur peut être lié à un profil Technicien.
     */
    public function technicien()
    {
        return $this->hasOne(Technicien::class, 'user_id');
    }
}
