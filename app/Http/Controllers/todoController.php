<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Item;
use Validator;

class todoController extends Controller
{

    // validate rule定義
    protected static $EMAIL_RULE = 'required|email';
    protected static $PASSWORD_MAKE_RULE = 'required|min:8|max:16';
    protected static $PASSWORD_CHECK_RULE = 'required|required_with:email';

    //ログイン前の画面
    public function root(Request $request)
    {
        return view('selection.root');
    }

    // ホーム画面
    public function home()
    {
        $yetItems = Item::getItems(0);
        $currentItems = Item::getItems(1);
        $finishItems = Item::getItems(2);

        return view('selection.home', compact(['yetItems', 'currentItems', 'finishItems']));
    }

    public function addItem(Request $request)
    {
        $param = $request->only(['userid', 'status', 'title', 'message']);

        Item::addItem($param);

        return redirect('/home');
    }

    public function changeItem(Request $request)
    {
        $param = $request->only(['status', 'title', 'message', 'id']);
        Item::changeItem($param);

        return redirect('/home');
    }

    // 登録操作時
    public function registerCheck(Request $request)
    {
        // 入力CHECK
        $validate = Validator::make(
            $request->all(),
            [
                'name'  => 'required|unique:users,name',
                'email' => self::$EMAIL_RULE,
                'password' => self::$PASSWORD_MAKE_RULE,
            ]
        );

        // エラー処理 非同期でエラー表示を行う。
        // if ($validate->fails()) {
        return $validate->messages();
        // }

        User::setUsersData($request);
        // return redirect('/home');
    }

    // 登録成功時処理
    public function registerSuccess(Request $request)
    {
        User::setUsersData($request);
        return redirect('/home');
    }

    // ログイン操作時
    public function loginCheck(Request $request)
    {
        // 入力CHECK
        $validate = Validator::make(
            $request->all(),
            [
                'email' => self::$EMAIL_RULE,
                'password' => self::$PASSWORD_CHECK_RULE,
            ]
        );

        // エラー処理 非同期でエラー表示を行う。
        if ($validate->fails()) {
            return $validate->messages();
        }

        // ログイン可能かCHECK
        $isLogin = User::loginUser($request);

        if ($isLogin == true) {
            return []; //空のデータを送信
        } else {
            return ['loginError' => "ログインできませんでした"];
        }
    }

    // ログインチェック成功時処理
    public function loginSuccess()
    {
        //[メモ]loginUserメソッドでsessionにデータを入れているが、ここでするほうが良さそう
        session()->flash('loginMessage', 'ログインに成功しました');
        return redirect('/home');
    }

    // ログアウト操作時
    public function logout()
    {
        User::logoutUser();
        return redirect('/');
    }

    // マイページ遷移時
    public function mypage()
    {
        return view('selection.mypage');
    }

    // チェンジパスボタン押下時のajaxのポスト受信
    public function changePass(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'password'                => self::$PASSWORD_CHECK_RULE,
                'newpassword'                 => self::$PASSWORD_MAKE_RULE . '|confirmed:newpassword',
                'newpassword_confirmation'    => 'required_with:newpassword',
            ]
        );

        // 入力エラーがあるなら
        if ($validate->fails()) {
            return $validate->messages();
        }

        $isSuccess = User::changePassword($request);

        // パスワード変更成功・失敗
        if ($isSuccess === 'error1') {
            return ['password' => 'パスワードが違います'];
        } else if ($isSuccess === 'error2') {
            return ['newpassword' => 'パスワードが変更されていません'];
        } else {
            return ['success' => 'パスワードを変更しました'];
        }
    }
}
