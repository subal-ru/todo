<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

class UsersInGroup extends Model
{
    use HasFactory;

    protected $table = 'users_in_group';

    // ユーザーとグループの紐付け
    public static function setUser($request)
    {

        $group_id = Group::getGroupID($request->name)->id;

        $param = [
            'group_id' => $group_id,
            'user_id' => $request->userid,
            'authority' => TRUE,
            'color' => $request->color,
        ];

        UsersInGroup::insert($param);
    }

    // useridとgroupidからグループを一件入手
    public static function getGroup($userid, $groupid)
    {
        return UsersInGroup::where('user_id', $userid)->where('group_id', $groupid)->first();
    }

    // useidからグループを全権取得
    public static function getGroups($userid)
    {
        return UsersInGroup::select('users_in_group.group_id', 'groups.name')
            ->leftJoin('groups', 'users_in_group.group_id', '=', 'groups.id')
            ->where('users_in_group.user_id', '=', session('userid'))
            ->get();
    }

    // visibleの変更
    public static function setVisibleData($userid, $groupid, $isVisible)
    {
        // boolに変換
        $visible = TRUE;
        if ($isVisible === 'false') {
            $visible = FALSE;
        } else if ($isVisible === 'true') {
            $visible = TRUE;
        }

        return UsersInGroup::where([
            ['group_id', '=', $groupid],
            ['user_id', '=', $userid],
        ])->update(['visible' => $visible]);
    }
}
