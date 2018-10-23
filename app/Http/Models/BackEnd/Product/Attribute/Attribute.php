<?php

namespace App\Http\Models\BackEnd\Product\Attribute;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Attribute extends Model
{
    protected $table='attribute';
    protected $primaryKey='attribute_id';
    protected $fillable=[
    	'attribute_group_id',
    	'sort_order'
    ];
    public $timestamps=false;
    static function AllAttribute()
    {
        $Attribute=DB::table('attribute_description as atd')
        		  ->Join('attribute as atr','atd.attribute_id','=','atr.attribute_id')
                  ->Join('language as lng','lng.language_id','=','atd.language_id')
                  ->Join('attribute_group_description as atgd','atgd.attribute_group_id','=','atr.attribute_group_id')
                  ->select('atr.attribute_id','atd.name as description','atgd.name as group','lng.name as language')
                  ->get();
        return $Attribute;
    }
}
