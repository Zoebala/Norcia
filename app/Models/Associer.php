<?php

namespace App\Models;

use App\Models\Employe;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Associer extends Model
{
    use HasFactory;

    protected $fillable=["departement_id","employe_id","created_at","updated_at"];

   

}
