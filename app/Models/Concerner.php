<?php

namespace App\Models;

use App\Models\Produit;
use App\Models\Pointvente;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Concerner extends Model
{
    use HasFactory;

    protected $fillable=["departement_id","pointvente_id","created_at","updated_at"];

     protected $casts=[
        "produit_id"=>"array",
    ];

   
    public function departement():BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
    public function pointvente():BelongsTo
    {
        return $this->belongsTo(Pointvente::class);
    }

}
