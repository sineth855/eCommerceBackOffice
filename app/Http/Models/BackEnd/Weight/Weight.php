<?php

namespace App\Http\Models\BackEnd\Weight;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Weight extends Model
{
    protected $table='weight_class';
    protected $primaryKey='weight_class_id';
    protected $fillable=[
    	'value'
    ];
    public $timestamps=false;
    static function AllWeights()
    {
        $taxRate=DB::table('weight_class')
                  ->leftJoin('weight_class_description','weight_class.weight_class_id','=','weight_class_description.weight_class_id')
                  ->leftJoin('language','language.language_id','=','weight_class_description.language_id')
                  ->select('weight_class.weight_class_id','weight_class_description.title','weight_class.value','language.name as language','unit')
                  ->get();
        return $taxRate;
    }
    static function WeightEdit($id)
    {
        $taxRate=DB::table('weight_class')
                  ->leftJoin('weight_class_description','weight_class.weight_class_id','=','weight_class_description.weight_class_id')
                  ->select('weight_class.weight_class_id','weight_class_description.title','weight_class.value','weight_class_description.language_id','unit')
                  ->where('weight_class.weight_class_id',$id)
                  ->get();
        return $taxRate;
    }
    static function weight_class($id){
    	return static::where('weight_class_id',$id);
    }
    public function Description($id){
    	return $this->hasOne(WeightDescription::class,'weight_class_id','weight_class_id')->where('weight_class_id',$id);
    }
    static function GetEdit($id){
    		$weight_class=static::weight_class(1)->get();
    	foreach($weight_class as $weight){
    		$weight=$weight->Description(1)->get();
    	}
    	
    }
}
