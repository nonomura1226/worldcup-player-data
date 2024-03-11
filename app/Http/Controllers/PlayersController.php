<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Players;

class PlayersController extends Controller
{
    public function index(){
        $players = Players::paginate(20);
        return view('players.index', ['players' => $players]);
    }
    public function showDetail($id)
    {
        // 選手IDに対応する選手のデータを取得する
        $player = Players::findOrFail($id);

        // 選手のデータを詳細ビューに渡して表示する
        return view('players.detail', ['player' => $player]);
    }
}
