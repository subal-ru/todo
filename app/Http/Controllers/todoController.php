<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Item;
use App\Models\Group;
use App\Models\UsersInGroup;
use App\Models\ItemsInGroup;
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
        // ステータス0:未着手 1:作業中 2:完了
        $yetItems = Item::getItems(0);
        $currentItems = Item::getItems(1);
        $finishItems = Item::getItems(2);

        $groupList = [];
        $groups = Group::getMyGroups();
        foreach ($groups as $group) {
            $data = UsersInGroup::getGroup(session('userid'), $group->id);
            $groupList[] = [
                'id'   => $group->id,
                'name' => $group->name,
                'color' => $data->color,
                'visible' => $data->visible,
            ];
        }

        return view('selection.home', compact(['yetItems', 'currentItems', 'finishItems', 'groupList']));
    }

    // アイテム追加
    public function addItem(Request $request)
    {
        $param = $request->only(['userid', 'status', 'title', 'message']); //重複チェック考える
        $item = Item::addItem($param);

        // itemとgroup紐付ける
        ItemsInGroup::setData($request->groupid, $item->id);

        return redirect('/home');
    }

    // アイテムの内容変更
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

        // User::setUsersData($request);
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

        if ($isLogin === true) {
            return []; //空のデータを送信
        } else if ($isLogin === 'error2') {
            return ['loginError' => "ログインできませんでした"];
        } else if ($isLogin === 'error1') {
            return ['email' => "メールアドレスが登録されていません"];
        } else {
            return ['loginError' => '予期しないエラー'];
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

    // グループ追加ボタンのリクエスト送信時
    public function addGroup(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'userid' => 'required', //これがないということはsessionが切れている
                'name' => 'required',
                'color' => 'required', //value指定あるので未設定になることはない
            ]
        );

        if ($validate->fails()) {
            return $validate->messages();
        }

        //エラーなし時空データ送信
        return [];
    }

    // グループ追加入力データチェックOK
    public function addGroupSuccess(Request $request)
    {
        Group::makeGroup($request); //グループの新規作成
        UsersInGroup::setUser($request); //グループユーザーを紐付けるため専用のDBへ登録

        return redirect('/home');
    }

    // グループon,off切り替え時にリダイレクトし表示アイテムを更新する
    public function groupToggle(Request $request)
    {
        UsersInGroup::setVisibleData(session('userid'), $request->groupid, $request->isVisible);

        return redirect('/home');
    }
}
