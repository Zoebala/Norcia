<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Produit;
use App\Models\Departement;
use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entree extends Model
{
    use HasFactory;

    protected $fillable=["qte","prix","departement_id","produit_id","fournisseur_id","annee_id","created_at","updated_at"];

    public function departement():BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
    public function produit():BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
    public function fournisseur():BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }
    public function annee():BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }
}
