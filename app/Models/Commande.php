<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Elementscommande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $fillable=["client_id","etat","annee_id","created_at","updated_at"];


    public function elementscommande():HasMany
    {
        return $this->hasMany(Elementscommande::class);
    }
    public function client():BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    public function annee():BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }
}
