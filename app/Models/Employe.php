<?php

namespace App\Models;

use App\Models\Vendeur;
use App\Models\Fonction;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employe extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $casts=[
        "formation_suivie"=>"json",
        "elements_dossiers"=>"json"
    ];

    public function fonction():BelongsTo
    {
        return $this->belongsTo(Fonction::class);
    }

    public function departements():BelongsToMany
    {
        return $this->belongsToMany(Departement::class,'associers')->withTimestamps();
    }

    public function vendeurs():HasMany
    {
        return $this->hasMany(Vendeur::class);
    }
}
