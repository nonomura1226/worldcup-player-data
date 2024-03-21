<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pairings extends Model
{
    public function myCountry()
    {
        return $this->belongsTo(Country::class, 'my_country_id');
    }

    public function enemyCountry()
    {
        return $this->belongsTo(Country::class, 'enemy_country_id');
    }

}