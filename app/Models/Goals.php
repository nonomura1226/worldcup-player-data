<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goals extends Model
{
    public function pairings()
    {
        return $this->belongsTo(Pairings::class, 'player_id');
    }

}