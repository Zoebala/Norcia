<?php

namespace App\Models;

use App\Models\Departement;
use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Avoir extends Model
{
    use HasFactory;

    protected $fillable=["departement_id","fournisseur_id","created_at","updated_at"];



  
}
