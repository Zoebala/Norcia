<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elementsentreedate extends Model
{
    use HasFactory;

    protected $fillable=["lib","qte","prix","entree_id","created_at","updated_at"];

    public function entrees():BelongsTo
    {
        return $this->belongsTo(Entree::class);
    }
}
