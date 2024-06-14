<?php

namespace App\Models;

use App\Models\Vendeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pointvente extends Model
{
    use HasFactory;

    protected $fillable=["lib","adresse","tel","produit_id","departement_id","created_at","updated_at"];

    protected $casts=[
        "produit_id"=>"json",
    ];

    public function vendeurs():HasMany
    {
        return $this->hasMany(Vendeur::class);
    }
    


}

