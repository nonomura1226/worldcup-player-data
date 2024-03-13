<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Players;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PlayersController extends Controller
{
    public function index(){

        // 直前URLのセッション情報の破棄
        Session::forget('previous_url');
        // 直前URLのセッション情報に一覧画面URLを保存
        Session::put('previous_url', route('players.index'));

        // 選手データの取得、表示
        $players = Players::paginate(20);
        return view('players.index', ['players' => $players]);
    }

    public function showDetail($id)
    {
        // 直前URLのセッション情報を取得
        $previousUrl = Session::get('previous_url');
        // 直前URLのセッション情報が存在しないまたは一覧画面URLではない場合
        if(!$previousUrl || $previousUrl !== route('players.index')) {
            // 一覧画面にリダイレクト
            return redirect()->route('players.index');
        }

        // 直前URLのセッション情報の破棄
        Session::forget('previous_url');

        try {
            // 選手IDに対応する選手のデータを取得
            $player = Players::findOrFail($id);

            // 選手のデータを詳細ビューに渡して表示
            return view('players.detail', ['player' => $player]);

        } catch (ModelNotFoundException $e) {
            // プレイヤーが見つからなかった場合、一覧画面にリダイレクト
            return redirect()->route('players.index');
        }
    }

}