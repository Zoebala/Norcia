<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Stock;
use App\Models\Entree;
use App\Models\Sortie;
use App\Models\Commande;
use App\Models\Pointvente;
use App\Models\Departement;
use App\Models\Ravitaillement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;

    protected $fillable=["lib","prix","qte","photo","actif","departement_id","annee_id","created_at","updated_at"];


    public function departement():BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
    public function annee():BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }

    public function pointventes():BelongsToMany
    {
        return $this->belongsToMany(Pointvente::class,'concerners')->withTimestamps();
    }

    public function entrees():HasMany
    {
        return $this->hasMany(Entree::class);

    }
    public function sorties():HasMany
    {
        return $this->hasMany(Sortie::class);

    }
    public function stocks():HasMany
    {
        return $this->hasMany(Stock::class);

    }
    public function ravitaillements():HasMany
    {
        return $this->hasMany(Ravitaillement::class);

    }
    public function commandes():HasMany
    {
        return $this->hasMany(Commande::class);

    }




}
