<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Produit;
use App\Models\Vendeur;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;
    protected $fillable=["departement_id","vendeur_id","annee_id"];



    public function vendeur():BelongsTo
    {
        return $this->belongsTo(Vendeur::class);
    }
    public function annee():BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }
    public function departement():BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
}
