<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // usersテーブルにレコード追加と追加の際にパスワードをハッシュ化
    public static function setUsersData(Request $request)
    {

        $param = [
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ];

        // DB::insert('insert into users (name, email, password) values (:name, :email, :password)', $param);
        User::insert($param);
    }

    // ログインチェックとログインまで
    public static function loginUser(Request $request)
    {
        $param = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];

        $user = DB::table('users')->where('email', $param['email'])->first();

        // passwordのチェック
        if (Hash::check($param['password'], $user->password)) {

            // セッション
            session([
                'name' => $user->name,
                'email' => $user->email,
                'userid' => $user->id
            ]);

            return true;
        } else {

            return false;
        }
    }

    // ログアウト処理
    public static function logoutUser()
    {
        // セッション情報を削除する
        session()->forget(['name', 'email', 'userid']);

        //ログアウト時メッセージを表示する 
        session()->flash('loginMessage', 'ログアウトしました');

        return true;
    }

    // パスワード変更
    public static function changePassword(Request $request)
    {
        $param = $request->only(['userid', 'password', 'newpassword']);

        // 旧パスの一致確認
        $myuser = User::where('users.id', $param['userid'])->first();
        if (!Hash::check($param['password'], $myuser->password)) {
            return 'error1';
        }

        // 旧パスと新規パスの不一致確認
        if ($param['password'] == $param['newpassword']) {
            return 'error2';
        }

        // パスワードのhash化とDB更新
        $hashPass = Hash::make($param['newpassword']);
        User::where('users.id', $param['userid'])->update(['password' => $hashPass]);

        return true;
    }
}
