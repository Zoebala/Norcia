<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Produit;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sortie extends Model
{
    use HasFactory;

    protected $fillable=["qte","produit_id","annee_id","created_at","updated_at"];

    public function produit():BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
    public function departement():BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
    public function annee():BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }


}
