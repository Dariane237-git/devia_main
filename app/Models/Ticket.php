<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    // Les attributs que l'on peut assigner en masse
    protected $fillable = ['date_creation', 'description_panne', 'statut', 'priorite', 'id_client', 'id_mat'];

    /**
     * Ce ticket a été déclaré par un client spécifique.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    /**
     * Ce ticket concerne un matériel précis.
     */
    public function materiel()
    {
        return $this->belongsTo(Materiel::class, 'id_mat');
    }

    /**
     * Ce ticket va générer un seul devis.
     */
    public function devis()
    {
        return $this->hasOne(Devis::class, 'id_ticket');
    }
}
