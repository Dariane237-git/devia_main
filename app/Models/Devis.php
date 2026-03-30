<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    // Les attributs que l'on peut assigner en masse
    protected $fillable = ['date_devis', 'statut', 'mont_estimer', 'frais_diagnostic', 'id_ticket'];

    /**
     * Ce devis est lié à un ticket spécifique.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }

    /**
     * Si le devis est validé, il donnera lieu à une intervention.
     */
    public function intervention()
    {
        return $this->hasOne(Intervention::class, 'id_devis');
    }

    /**
     * Le devis générera une facture.
     */
    public function facture()
    {
        return $this->hasOne(Facture::class, 'id_devis');
    }

    /**
     * Les pièces détachées prévues pour ce devis (Relation Plusieurs-à-Plusieurs).
     */
    public function pieces()
    {
        return $this->belongsToMany(Piece::class, 'devis_piece', 'id_devis', 'id_piece')
                    ->withPivot('qte_prevu', 'pu_devis')
                    ->withTimestamps();
    }
}
