<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Vendeur;
use App\Models\Concerner;
use App\Models\Pointvente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pointvente extends Model
{
    use HasFactory;

    protected $fillable=["lib","adresse","tel","annee_id","created_at","updated_at"];

    protected $casts=[
        "produit_id"=>"json",
    ];

    public function annee():BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }

    public function concerners():HasMany
    {
        return $this->hasMany(Concerner::class);
    }

    public function vendeurs():HasMany
    {
        return $this->hasMany(Vendeur::class);
    }



}

