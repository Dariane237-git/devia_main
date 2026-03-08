<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    // Les attributs que l'on peut assigner en masse
    protected $fillable = ['numero_fac', 'date_emission', 'mont_total', 'type_fac', 'statut_paiement', 'id_devis'];

    /**
     * La facture provient toujours d'un devis.
     */
    public function devis()
    {
        return $this->belongsTo(Devis::class, 'id_devis');
    }
}
