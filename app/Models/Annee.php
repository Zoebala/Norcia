<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annee extends Model
{
    use HasFactory;

    protected $fillable=["lib","created_at","updated_at"];

    public static function isActive()
    {

        return session("Annee_id") ? true : false;
    }


}
