<?php

namespace App\Models;

use App\Models\Pointvente;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Concerner extends Model
{
    use HasFactory;

    protected $fillable=["departement_id","pointvente_id","produit_id","created_at","updated_at"];

    protected $casts=[
        "produit_id"=>"json",
    ];

    // public function departements():BelongsToMany
    // {
    //     return $this->belongsToMany(Departement::class)->withTimestamps();
    // }
    // public function pointventes():BelongsToMany
    // {
    //     return $this->belongsToMany(Pointvente::class)->withTimestamps();
    // }
}
