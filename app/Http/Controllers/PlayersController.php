<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Players;
use App\Models\Users;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;

class PlayersController extends Controller
{
    public function index(){

        // 直前URLのセッション情報の破棄
        Session::forget('previous_url');
        // 直前URLのセッション情報に一覧画面URLを保存
        Session::put('previous_url', route('players.index'));

        // ユーザーIDをセッションから取得
        $userId = session('user_id');

        // ユーザーIDを使用してユーザーのroleとcountry_idを取得
        $user = Users::findOrFail($userId);
        $role = $user->role;
        $countryId = $user->country_id;

        // 選手データの取得、表示（del_flgが0、かつcountry_idが同じ選手のみ）
        $players = Players::where('del_flg', 0)
        ->where('country_id', $countryId)
        ->with('country')
        ->paginate(20);
        return view('players.index', ['players' => $players, 'role' => $role]);
    }

    public function showDetail($id)
    {
        // 直前URLのセッション情報を取得
        $previousUrl = Session::get('previous_url');
        // 直前URLのセッション情報が存在しないまたは一覧画面URLではない場合
        if(!$previousUrl || $previousUrl !== route('players.index')) {
            // 一覧画面にリダイレクト
            return redirect()->route('players.index');

        }else{
            // 直前URLのセッション情報に詳細画面URLを保存
            Session::put('previous_url', route('players.showDetail', ['id' => $id]));
        }

        try {
            // 選手IDに対応する選手のデータを取得
            $player = Players::with('country', 'goals', 'pairings.myCountry', 'pairings.enemyCountry')->findOrFail($id);

            // 選手の総ゴール数をカウント
            $goalsCount = $player->goals->count();

            if(!$goalsCount){
                $goalsCount = "無得点です。";

            }else{
                $goalsCount = strval($goalsCount) . "点";
            }

            // 選手のデータとゴール数を詳細ビューに渡して表示
            return view('players.detail', [
                'player' => $player,
                'goalsCount' => $goalsCount,
            ]);

        } catch (ModelNotFoundException $e) {
            // プレイヤーが見つからなかった場合、一覧画面にリダイレクト
            return redirect()->route('players.index');
        }
    }

    public function edit($id)
    {
        // 直前URLのセッション情報を取得
        $previousUrl = Session::get('previous_url');

        if($previousUrl && $previousUrl === route('players.edit', ['id' => $id])){
            // 直前URLのセッション情報が選手編集画面URLの場合は、編集時なので何も行わない。

        }elseif(!$previousUrl || $previousUrl !== route('players.index')) {
            // 直前URLのセッション情報が存在しないまたは一覧画面URLではない場合は一覧画面にリダイレクト
            return redirect()->route('players.index');

        }else{
            // 直前URLのセッション情報に選手編集画面URLを保存
            Session::put('previous_url', route('players.edit', ['id' => $id]));
        }

        try {
            // 選手IDに対応する選手のデータを取得
            $player = Players::with('country')->findOrFail($id);

            $countryNames = DB::table('countries')
            ->select('id', 'name')
            ->groupBy('id', 'name')
            ->get();

            // 選手のデータと国名を詳細ビューに渡して表示
            return view('players.edit', [
                'player' => $player,
                'countryNames' => $countryNames,
            ]);

        } catch (ModelNotFoundException $e) {
            // プレイヤーが見つからなかった場合、一覧画面にリダイレクト
            return redirect()->route('players.index');
        }
    }

    public function update(Request $request, $id){
        {
            // バリデーションルール
            $rules = [
                'uniform_num' => 'required|numeric',
                'position' => 'required',
                'name' => 'required',
                'country_id' => 'required',
                'club' => 'required',
                'birth' => 'required|date|date_format:Y-m-d',
                'height' => 'required|numeric',
                'weight' => 'required|numeric',
            ];

            // エラーメッセージ
            $messages = [
                'required' => 'この項目は必須項目です。',
                'numeric' => 'この項目は半角数字で入力してください。',
                'date' => 'この項目は「YYYY-MM-DD」で入力してください。',
                'date_format' => 'この項目は「YYYY-MM-DD」で入力してください。',
            ];

            // バリデーションを実行
            $validator = Validator::make($request->all(), $rules, $messages);

            // バリデーションが失敗した場合
            if ($validator->fails()) {
                // バリデーションエラーがあれば、直前のページにリダイレクトし、エラーメッセージと入力値を保持する
                return redirect()->route('players.edit', ['id' => $id])->withErrors($validator)->withInput();
            }

            // バリデーションを通過した場合、データを更新する
            $player = Players::findOrFail($id);
            $player->update($request->all());

            // players_tmpテーブルを一度全削除
            DB::table('players_tmp')->truncate();

            // playersテーブルのデータを取得し、players_tmpテーブルにデータを挿入
            $players = Players::with('country')->get();
            foreach ($players as $player) {
                DB::table('players_tmp')->insert([
                    'country' => $player->country->name,
                    'uniform_num' => $player->uniform_num,
                    'position' => $player->position,
                    'name' => $player->name,
                    'club' => $player->club,
                    'birth' => $player->birth,
                    'height' => $player->height,
                    'weight' => $player->weight,
                ]);
            }

            // 更新が完了したら一覧画面にリダイレクト
            return redirect()->route('players.index')->with('success', '選手の情報を更新しました。');
        }
    }

    public function delete($id)
    {

        try {
            // 削除対象の選手の削除フラグを更新する
            Players::where('id', $id)->update(['del_flg' => 1]);

            // 更新が完了したら一覧画面にリダイレクト
            return redirect()->route('players.index')->with('success', '選手の情報を削除しました。');

        } catch (ModelNotFoundException $e) {
            // プレイヤーが見つからなかった場合、一覧画面にリダイレクト
            return redirect()->route('players.index')->with('error', '選手が見つかりませんでした。');
        }
    }

}