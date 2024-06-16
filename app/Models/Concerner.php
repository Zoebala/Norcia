<?php

namespace App\Models;

use App\Models\Pointvente;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Concerner extends Model
{
    use HasFactory;

    protected $fillable=["departement_id","pointvente_id","created_at","updated_at"];

    public function departement():BelongsToMany
    {
        return $this->belongsToMany(Departement::class)->withTimestamps();
    }
    public function pointvente():BelongsToMany
    {
        return $this->belongsToMany(Pointvente::class)->withTimestamps();
    }
}
