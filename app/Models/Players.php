<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    // update_atカラムの自動更新を無効に
    public $timestamps = false;

    // フォーム送信用
    protected $fillable = [
        'uniform_num',
        'position',
        'name',
        'country_id',
        'club',
        'birth',
        'height',
        'weight',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function goals()
    {
        return $this->hasMany(Goals::class, 'player_id');
    }

    public function pairings()
    {
        return $this->hasManyThrough(Pairings::class, Goals::class, 'player_id', 'id', 'id', 'pairing_id');
    }

}