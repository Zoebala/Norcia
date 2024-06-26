<?php

namespace App\Models;

use App\Models\Sortie;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Elementssortie extends Model
{
    use HasFactory;
    protected $fillable=["qte","produit_id","total","sortie_id"];

    public function sortie():BelongsTo
    {
        return $this->belongsTo(Sortie::class);
    }

    public function produit():BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
