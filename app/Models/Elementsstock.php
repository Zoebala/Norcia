<?php

namespace App\Models;

use App\Models\Stock;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Elementsstock extends Model
{
    use HasFactory;

    protected $fillable=["qte","produit_id","stock_id","total","created_at","updated_at"];

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

}
