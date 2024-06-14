<?php

namespace App\Models;

use App\Models\Employe;
use App\Models\Pointvente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendeur extends Model
{
    use HasFactory;
    protected $fillable=["pointvente_id","employe_id","ville"];

    public function pointvente():BelongsTo
    {
        return $this->belongsTo(Pointvente::class);
    }
    public function employe():BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }
}
