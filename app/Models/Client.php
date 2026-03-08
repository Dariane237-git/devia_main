<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // Les attributs que l'on peut assigner en masse
    protected $fillable = ['adresse_clt', 'type_clt', 'user_id'];

    /**
     * Le client est lié à un compte utilisateur de base.
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'user_id');
    }

    /**
     * Un client possède un ou plusieurs matériels.
     */
    public function materiels()
    {
        return $this->hasMany(Materiel::class, 'id_client');
    }

    /**
     * Un client peut déclarer plusieurs tickets de panne.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_client');
    }
}
