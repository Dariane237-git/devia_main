<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    // Les attributs que l'on peut assigner en masse
    protected $fillable = ['nom', 'prenom', 'email', 'tel', 'mot_de_passe', 'id_role'];

    // Les attributs cachés lors de la sérialisation (ex: envoi en JSON)
    protected $hidden = ['mot_de_passe'];

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
