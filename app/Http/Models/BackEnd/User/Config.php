<?php

namespace App\Http\Models\BackEnd\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Config extends Model
{
    protected $table='setting';
    public $timestamps=false;
    protected $primaryKey='setting_id';
    protected $fillable=[
		'key',
		'value',
		'store_id',
		'code',
		'serialized'
    ]; 

    static function getConfigToUpdate($id){
    	$config=DB::table('store as s')
    	->Join('setting as st','s.store_id','=','st.store_id')
    	->select('st.key','st.value')
    	->where('s.owner_id',$id)->get();
    	return $config;
    }
}
