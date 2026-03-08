<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technicien extends Model
{
    // Les attributs que l'on peut assigner en masse
    protected $fillable = ['specialite', 'disponibilite', 'user_id'];

    /**
     * Le technicien est lié à un compte utilisateur de base.
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'user_id');
    }

    /**
     * Un technicien réalise une ou plusieurs interventions.
     */
    public function interventions()
    {
        return $this->hasMany(Intervention::class, 'id_tech');
    }
}
