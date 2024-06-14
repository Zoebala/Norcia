<?php

namespace App\Models;

use App\Models\Employe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fonction extends Model
{
    use HasFactory;

    protected $fillable=["lib","created_at","updated_at"];

    public function employes():HasMany
    {
        return $this->hasMany(Employe::class);
    }

}
