<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elementsstockdate extends Model
{
    use HasFactory;

    protected $fillable=["qte","produit_id","stock_id","vendeur_id","total","created_at","updated_at"];

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}
