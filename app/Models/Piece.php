<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    // Les attributs que l'on peut assigner en masse
    protected $fillable = ['reference_fabricant', 'nom', 'pu', 'stock_disponible'];

    /**
     * Une pièce peut apparaître dans plusieurs devis (ce que l'on prévoit d'utiliser).
     */
    public function devis()
    {
        return $this->belongsToMany(Devis::class, 'devis_piece', 'id_piece', 'id_devis')
                    ->withPivot('qte_prevu', 'pu_devis')
                    ->withTimestamps();
    }

    /**
     * Une pièce peut être utilisée dans plusieurs interventions (ce qui a été réellement utilisé).
     */
    public function interventions()
    {
        return $this->belongsToMany(Intervention::class, 'inter_piece', 'id_piece', 'id_int')
                    ->withPivot('qte_reel_utiliser')
                    ->withTimestamps();
    }
}
