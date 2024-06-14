<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Produit;
use App\Models\Vendeur;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ravitaillement extends Model
{
    use HasFactory;

    protected $fillable=["produit_id","vendeur_id","annee_id","qte","departement_id"];

    public function produit():BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
    public function departement():BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
    public function vendeur():BelongsTo
    {
        return $this->belongsTo(Vendeur::class);
    }
    public function annee():BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }
}
