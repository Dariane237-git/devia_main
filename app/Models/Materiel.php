<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materiel extends Model
{
    // Les attributs que l'on peut assigner en masse
    protected $fillable = ['nom', 'marque', 'modele', 'date_achat', 'garantie', 'id_client'];

    /**
     * Ce matériel appartient à un client spécifique.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    /**
     * Un matériel peut faire l'objet de plusieurs tickets de panne au cours de sa vie.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_mat');
    }
}
