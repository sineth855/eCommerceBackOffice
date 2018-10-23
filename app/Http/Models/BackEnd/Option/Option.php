<?php

namespace App\Http\Models\BackEnd\Option;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Option extends Model
{
	protected $table='option';
	protected $primaryKey='option_id';
	protected $fillable=[
		'type',
		'sort_order'
	];
	public $timestamps=false;
	static function AllOptions()
	{
	  $Option=DB::table('option_description as optdesc')
	            ->Join('option as opt','opt.option_id','=','optdesc.option_id')
	            ->Join('language','language.language_id','=','optdesc.language_id')
	            ->select('opt.sort_order','opt.option_id','optdesc.name as name','language.name as language','optdesc.language_id')
	            ->get();
	  	return $Option;
	}
	// public function OptionValue()
	// {
	// 	$option_id=1;
	// 	return $this->hasMany(Option::class,'category_id')->where('language_id',$language_id);
	// }
	static function Options($id,$lid){
		return DB::table('option_description as optdesc')
	            ->leftJoin('option as opt','opt.option_id','=','optdesc.option_id')
	            ->leftJoin('option_value as optv','optv.option_id','=','opt.option_id')
	            ->select('opt.option_id','optv.option_value_id','optdesc.name as name','optdesc.language_id','opt.sort_order','optdesc.language_id')
	            ->where(['opt.option_id'=>$id,'optdesc.language_id'=>$lid]);
	}
	static function OptionValues($id,$lid){
		return DB::table('option_value as optv')
	            	->Join('option_value_description as opt_desc',function($q)
	            	{
	            		$q->on('optv.option_id','=','opt_desc.option_id')
	            		->on('optv.option_value_id','=','opt_desc.option_value_id');
	            	})
	            	->select('opt_desc.option_value_id','name','sort_order','image')
	            	->where(['optv.option_id'=>$id,'opt_desc.language_id'=>$lid]);
	}
	static function OptionEdit($id,$lid)
	{
		$OptionArr=static::Options($id,$lid)->get();
	    foreach($OptionArr as $k=>$v){
	    	$optValue=static::OptionValues($v->option_id,$v->language_id)->get();
	    	$v->optionValues=$optValue->toArray();
	    }
	  	return $OptionArr;
	}
	static function DeleteOptionValue($id,$lid)
	{
		$sql="DELETE optv,opt_desc
		FROM sg_option_value optv JOIN sg_option_value_description opt_desc
		ON optv.option_value_id=opt_desc.option_value_id
		AND optv.`option_id`=opt_desc.`option_id`
		WHERE opt_desc.language_id='".$lid."' AND optv.option_id='".$id."'";

		return DB::delete($sql);
	}
}
