<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Avoir;
use App\Models\Entree;
use App\Models\Sortie;
use App\Models\Produit;
use App\Models\Associer;
use App\Models\Concerner;
use App\Models\Pointvente;
use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Departement extends Model
{
    use HasFactory;

    protected $fillable=["lib","annee_id","actif","created_at","updated_at","description"];

    public function annee():BelongsTo
    {
        return $this->BelongsTo(Annee::class);
    }
    public function pointventes():BelongsToMany
    {
        return $this->belongsToMany(Pointvente::class,'concerners')->withTimestamps();
    }

    public function fournisseurs():BelongsToMany
    {
        return $this->belongsToMany(Fournisseur::class,'avoirs')->withTimestamps();
    }
    public function associers():HasMany
    {
        return $this->HasMany(Associer::class);
    }
    public function avoirs():HasMany
    {
        return $this->HasMany(Avoir::class);
    }
    public function sorties():HasMany
    {
        return $this->HasMany(Sortie::class);
    }
    public function entrees():HasMany
    {
        return $this->HasMany(Entree::class);
    }


}
