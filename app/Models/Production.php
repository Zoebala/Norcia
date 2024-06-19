<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Produit;
use App\Models\Departement;
use App\Models\Elementsproduction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Production extends Model
{
    use HasFactory;
    protected $fillable=["annee_id","departement_id","produit_id","qte","created_at","updated_at"];


    public function annee():BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }
    public function produit():BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
    public function departement():BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
    public function elementsproduction():HasMany
    {
        return $this->hasMany(Elementsproduction::class);
    }
}
