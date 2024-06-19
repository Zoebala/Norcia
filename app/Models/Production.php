<?php

namespace App\Models;

use App\Models\Elementsproduction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Production extends Model
{
    use HasFactory;
    protected $fillable=["annee_id","departement_id","produit_id"];


    public function elementsproduction():HasMany
    {
        return $this->hasMany(Elementsproduction::class);
    }
}
