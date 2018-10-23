<?php

namespace App\Http\Models\BackEnd\Setting;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\BackEnd\Store\Store;
use Illuminate\Support\Facades\DB;

class Setting extends Model
{
    protected $table='setting';
    public $timestamps = false;
    protected $primaryKey='setting_id';
    protected $fillable=[
    	'store_id',
    	'code',
    	'key',
    	'value',
    	'serialized'
    ];
    static function AllSetting()
    {
        $settings=DB::table('setting')
                  ->leftJoin('store','store.store_id','=','setting.store_id')
                  ->select('setting_id as id','name','code','key')
                  ->get();
        return $settings;
    }
    static function FetchSettingItem()
    {
        $settings=DB::table('setting')
                  ->select('setting_id as id','code','key','value')
                  ->get();
        $itemsArr = array();
        foreach($settings as $item)
        {
            $itemsArr['code'][]=$item->code;
            $itemsArr['key'][]=$item->key;
            $itemsArr['value'][]=$item->value;
        }

        return $itemsArr;
    }
}
