<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    // グループ作成
    public static function makeGroup($request)
    {
        $param = [
            'name' => $request->name,
            'administrator_userid' => $request->userid,
        ];
        Group::insert($param);
    }

    // Myグループ取得
    public static function getMyGroups()
    {
        return Group::where('administrator_userid', session('userid'))->get();
    }

    // グループIDの取得
    public static function getGroupID($GroupName)
    {
        return Group::where('name', $GroupName)->where('administrator_userid', session('userid'))->first();
    }
}
