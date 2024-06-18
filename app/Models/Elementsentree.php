<?php

namespace App\Models;

use App\Models\Entree;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Elementsentree extends Model
{
    use HasFactory;

    protected $fillable=["lib","qte","prix","entree_id"];

    public function entrees():BelongsTo
    {
        return $this->belongsTo(Entree::class);
    }
}
