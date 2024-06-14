<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $fillable=["produit_id","client_id","qte","annee_id"];

    public function produit():BelongsTo
    {
        return $this->belongsTo(Produit::class);
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
