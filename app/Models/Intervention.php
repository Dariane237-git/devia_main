<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    // Les attributs que l'on peut assigner en masse
    protected $fillable = ['date_debut', 'date_fin', 'temps_passe_minute', 'statut', 'rapport_technn', 'id_devis', 'id_tech'];

    /**
     * Cette intervention découle d'un devis validé.
     */
    public function devis()
    {
        return $this->belongsTo(Devis::class, 'id_devis');
    }

    /**
     * Cette intervention est réalisée par un technicien précis.
     */
    public function technicien()
    {
        return $this->belongsTo(Technicien::class, 'id_tech');
    }

    /**
     * Les pièces réellement utilisées lors de l'intervention (Relation Plusieurs-à-Plusieurs).
     */
    public function pieces()
    {
        return $this->belongsToMany(Piece::class, 'inter_piece', 'id_int', 'id_piece')
                    ->withPivot('qte_reel_utiliser')
                    ->withTimestamps();
    }
}
