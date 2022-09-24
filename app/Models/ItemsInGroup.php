<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsInGroup extends Model
{
    use HasFactory;

    protected $table = 'items_in_group';

    public static function setData($groupid, $itemid)
    {
        $param = [
            'group_id' => $groupid,
            'item_id' => $itemid,
        ];

        ItemsInGroup::insert($param);
    }

    // グループIDの入手
    public static function getGroupID($itemid)
    {
        return ItemsInGroup::where('item_id', '=', $itemid)->first()->group_id;
    }
}
