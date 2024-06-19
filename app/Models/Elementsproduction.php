<?php

namespace App\Models;

use App\Models\Production;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Elementsproduction extends Model
{
    use HasFactory;

    protected $fillable=["production_id","elementsentree_id","qte","created_at","updated_at"];


    public function production():BelongsTo
    {
        return $this->belongsTo(Production::class);
    }
}
