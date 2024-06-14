<?php

namespace App\Models;

use App\Models\Avoir;
use App\Models\Entree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable=["nom","adresse","tel","created_at","updated_at"];

    public function avoirs():HasMany
    {
        return $this->hasMany(Avoir::class);
    }
    
    public function entrees():HasMany
    {
        return $this->hasMany(Entree::class);
    }

}
