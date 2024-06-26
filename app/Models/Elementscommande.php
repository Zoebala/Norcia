<?php

namespace App\Models;

use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Elementscommande extends Model
{
    use HasFactory;
    protected $fillable=["commande_id","produit_id","total","qte","created_at","updated_at"];

    public function commande():BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    public function produit():BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
