<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Produit;
use App\Models\Vendeur;
use App\Models\Concerner;
use App\Models\Pointvente;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pointvente extends Model
{
    use HasFactory;

    protected $fillable=["lib","adresse",'actif',"tel","annee_id","created_at","updated_at"];

   

    public function annee():BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }

    public function departements():BelongsToMany
    {
        return $this->belongsToMany(Departement::class,'concerners')->withTimestamps();
    }
    public function produits():BelongsToMany
    {
        return $this->belongsToMany(Produit::class,'concerners')->withTimestamps();
    }

    public function vendeurs():HasMany
    {
        return $this->hasMany(Vendeur::class);
    }



}

