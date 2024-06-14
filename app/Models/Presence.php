<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Employe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presence extends Model
{
    use HasFactory;
    protected $fillable=[
        "employe_id",
        "arrivee",
        "depart",
        "status",
        "BtnDepart",
        "BtnArrivee",
        "Observation",
        "annee_id"

    ];

    public function employe():BelongsTo
    {
        return $this->BelongsTo(Employe::class);
    }
    public function annee():BelongsTo
    {
        return $this->BelongsTo(Annee::class);
    }
}
