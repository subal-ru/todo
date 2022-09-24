<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    use HasFactory;

    protected $table = 'item';

    // status別のアイテム取得
    public static function getItems($status)
    {

        $items = Item::select('item.id', 'item.userid', 'item.title', 'item.message', 'item.status', 'users.name', 'items_in_group.group_id', 'users_in_group.color', 'groups.name as group_name')
            ->leftJoin('users', 'item.userid', '=', 'users.id')
            ->leftJoin('items_in_group', 'item.id', '=', 'items_in_group.item_id')
            ->leftJoin('users_in_group', 'items_in_group.group_id', '=', 'users_in_group.group_id')
            ->leftJoin('groups', 'items_in_group.group_id', '=', 'groups.id')
            ->where('item.status', $status)
            ->where('item.userid', session('userid'))
            ->where('users_in_group.visible', TRUE)
            ->get();
        return $items;
    }

    // item追加
    public static function addItem($param)
    {
        // DB::insert('insert into item (userid, status, title, message) value (:userid, :status, :title, :message)', $param);
        Item::insert($param);

        return Item::where([
            ['userid', '=', $param['userid']],
            ['title', '=', $param['title']],
            ['message', '=', $param['message']],
            ['status', '=', $param['status']]
        ])->first();;
    }

    // itemの更新
    public static function changeItem($param)
    {

        $param2 = ['status' => $param['status'], 'title' => $param['title'], 'message' => $param['message']];
        // DB::update('update item set status=:status, title=:title, message=:message where id = :id', $param);
        Item::where('id', $param['id'])->update($param2);
        return true;
    }

    // itemIDの取得
    public static function getItemID($userid, $title, $message, $status)
    {
        return Item::where('userid', '=', $userid)
            ->where('title', $title)
            ->where('message', $message)
            ->where('status', '=', $status)
            ->first()
            ->id;
    }
}
