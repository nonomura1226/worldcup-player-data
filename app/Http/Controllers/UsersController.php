<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Users;
use Validator;

class UsersController extends Controller
{
    public function login(){

        // ログイン画面の表示
        return view('users.login');
    }

    public function loginCheck(Request $request)
    {
        // バリデーションルールを定義
        $rules = [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ];

        // エラーメッセージ
        $messages = [
            'required' => 'この項目は必須項目です。',
            'email.email' => 'emailの形式で入力してください。',
            'email.exists' => 'このメールアドレスは登録されていません。'
        ];

        // バリデーションを実行
        $validator = Validator::make($request->all(), $rules, $messages);

        // バリデーションが失敗した場合
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        // 認証に成功した場合の処理
        if (Auth::attempt($credentials)) {
            // ログインしたユーザーのIDをセッションに保存する
            session(['user_id' => Auth::id()]);
            // 選手一覧画面に遷移
            return redirect()->intended(route('players.index'));
        }

        // パスワードが間違っている場合の処理
        return back()->withErrors(['password' => '入力されたパスワードは登録されている内容と違います。'])->withInput();
    }

    public function settingForm(){

        // 所属国を取得
        $countryNames = DB::table('countries')
        ->select('id', 'name')
        ->groupBy('id', 'name')
        ->get();

        // 国名を新規登録画面に渡して表示
        return view('users.setting', [
            'countryNames' => $countryNames,
        ]);

    }

    public function setting(Request $request){
        // バリデーションルール
        $rules = [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'role' => 'required',
            'country_id' => 'required'
        ];

        // エラーメッセージ
        $messages = [
            'required' => 'この項目は必須項目です。',
            'email.email' => 'emailの形式で入力してください。',
            'email.unique' => '入力されたメールアドレスはすでに登録されています。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワードが確認用と一致していません。'
        ];

        // バリデーションを実行
        $validator = Validator::make($request->all(), $rules, $messages);

        // バリデーションエラーがある場合は、新規登録画面に戻る
        if ($validator->fails()) {
            return redirect()->route('users.setting')
                ->withErrors($validator)
                ->withInput();
        }

        // ユーザーを作成
        $user = new Users();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->country_id = $request->country_id;
        $user->save();

        // 登録が成功したら、ログインページにリダイレクト
        return redirect()->route('users.login')->with('success', '登録が完了しました。');
    }

}