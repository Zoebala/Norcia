<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Avoir;
use App\Models\Entree;
use App\Models\Sortie;
use App\Models\Associer;
use App\Models\Pointvente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departement extends Model
{
    use HasFactory;

    protected $fillable=["lib","annee_id","created_at","updated_at","description"];

    public function annee():BelongsTo
    {
        return $this->BelongsTo(Annee::class);
    }
    public function pointventes():HasMany
    {
        return $this->HasMany(Pointvente::class);
    }
    public function associers():HasMany
    {
        return $this->HasMany(Associer::class);
    }
    public function avoirs():HasMany
    {
        return $this->HasMany(Avoir::class);
    }
    public function sorties():HasMany
    {
        return $this->HasMany(Sortie::class);
    }
    public function entrees():HasMany
    {
        return $this->HasMany(Entree::class);
    }


}
