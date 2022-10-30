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
use App\Rules\myname;

class todoController extends Controller
{

    // validate rule定義
    protected static $EMAIL_RULE = 'required|email';
    protected static $PASSWORD_MAKE_RULE = 'bail|required|between:8,16';
    protected static $PASSWORD_CHECK_RULE = 'bail|required|required_with:email';

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
        $groupids = UsersInGroup::getGroups(session('userid'));
        foreach ($groupids as $group) {
            if ($group->id) {
                $groupList[] = [
                    'id'   => $group->id,
                    'name' => $group->name,
                    'color' => $group->color,
                    'visible' => $group->visible,
                ];
            } else { //groupTableにデータがないものにはidとnameに指定の指定の値を入れる
                $groupList[] = [
                    'id'   => '0',
                    'name' => '未設定',
                    'color' => $group->color,
                    'visible' => $group->visible,
                ];
            }
        }

        $groups = UsersInGroup::getGroups(session('userid'));  //groupidsの修正で同じことをしているので、後ほど修正する

        return view('selection.home', compact(['yetItems', 'currentItems', 'finishItems', 'groupList', 'groups']));
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

        // アイテムのグループIDを変更
        $itemid = Item::getItemID(session('userid'), $request['title'], $request['message'], $request['status']);
        ItemsInGroup::updataItemGroup($itemid, $request['group']);

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
                'email' => self::$EMAIL_RULE, //email uniqeの重複チェックをしていない
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
        // ユーザー登録
        User::setUsersData($request);

        // グループユーザー登録（グループなし）
        $param = [
            'group_id' => 0,
            'user_id' => session('userid'),
            'authority' => FALSE,
            'color' => '#acacac',
        ];
        UsersInGroup::setUser($param);

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
    public function mypage(Request $request)
    {
        $groups = UsersInGroup::getGroups(session('users'));
        $groupMember = UsersInGroup::getGroupMember($request->select);
        $param = [
            'groups' => $groups,
            'menu' => $request->menu,
            'select' => $request->select,
            'groupMember' => $groupMember,
        ];
        // メンバーリストの取得

        return view('selection.mypage')->with($param);
    }

    // チェンジパスボタン押下時のajaxのポスト受信
    public function changePass(Request $request)
    {
        //Checkすつ順番を上から順番にするか まとめてチェックするか　独自のバリデートのルールを作った方が良い   
        $validate = Validator::make(
            $request->all(),
            [
                'password'                => 'required',
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
        $groupid = Group::getGroupID($request->name)->id;

        $param = [
            'group_id' => $groupid,
            'user_id' => $request->userid,
            'authority' => TRUE,
            'color' => $request->color,
        ];

        UsersInGroup::setUser($param); //グループユーザーを紐付けるため専用のDBへ登録

        return redirect('/home');
    }

    // グループon,off切り替え時にリダイレクトし表示アイテムを更新する
    public function groupToggle(Request $request)
    {
        UsersInGroup::setVisibleData(session('userid'), $request->groupid, $request->isVisible);

        return redirect('/home');
    }

    // グループにメンバー追加
    public function addMemberCheck(Request $request)
    {

        // 入力チェックをする usersテーブルのnameカラムにあるかどうか
        $validate = Validator::make($request->all(), [
            'name' => ['bail', 'required', ' exists:users,name', new myname($request->input('name'))],
        ]);

        //validateエラ-
        if ($validate->fails()) {
            return $validate->messages();
        }

        //  エラーがなければ,招待+成功文を作成して送信する
        //　とりあえずDBに追加する。追々、承認してから追加するように変更する
        $param = [
            'group_id' => $request->input('groupid'),
            'user_id' => User::getUserid($request->input('name')),
            'authority' => 0,
            'color' => UsersInGroup::getMyGroupColor($request->input('groupid'), session('userid')),
        ];
        UsersInGroup::setUser($param);
        return [
            'success' => $request->input('name') . 'をグループに招待しました.',
        ];
    }
}
