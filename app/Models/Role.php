<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Les attributs que l'on peut assigner en masse (Mass Assignment)
    protected $fillable = ['nom_role'];

    /**
     * Un rôle possède plusieurs utilisateurs.
     */
    public function utilisateurs()
    {
        return $this->hasMany(Utilisateur::class, 'id_role');
    }
}
