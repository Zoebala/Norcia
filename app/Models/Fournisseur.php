<?php

namespace App\Models;

use App\Models\Avoir;
use App\Models\Entree;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable=["nom","adresse","email","tel","created_at","updated_at"];

    // public function avoirs():HasMany
    // {
    //     return $this->hasMany(Avoir::class);
    // }

    public function departements():BelongsToMany
    {
        return $this->belongsToMany(Departement::class,'avoirs')->withTimestamps();
    }

    public function entrees():HasMany
    {
        return $this->hasMany(Entree::class);
    }

}
