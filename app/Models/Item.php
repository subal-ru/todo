<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    use HasFactory;

    // status別のアイテム取得
    public static function getItems($status)
    {
        // $items = Item::select('item.id', 'item.userid', 'item.title', 'item.message', 'item.status', 'users.name')->leftJoin('users', 'item.userid', '=', 'users.id')->where('status', $status)->where('item.userid', session('userid'))->get();
        $items = DB::table('item')->select('item.id', 'item.userid', 'item.title', 'item.message', 'item.status', 'users.name')->leftJoin('users', 'item.userid', '=', 'users.id')->where('status', $status)->where('item.userid', session('userid'))->get();

        return $items;
    }

    // item追加
    public static function addItem($param)
    {
        // DB::insert('insert into item (userid, status, title, message) value (:userid, :status, :title, :message)', $param);
        DB::table('item')->insert($param);
        return true;
    }

    // itemの更新
    public static function changeItem($param)
    {

        $param2 = ['status' => $param['status'], 'title' => $param['title'], 'message' => $param['message']];
        // DB::update('update item set status=:status, title=:title, message=:message where id = :id', $param);
        DB::table('item')->where('id', $param['id'])->update($param2);
        return true;
    }
}
