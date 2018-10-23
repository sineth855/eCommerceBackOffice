<?php

namespace App\Http\Models\BackEnd\Carrier;

use Illuminate\Database\Eloquent\Model;
use DB;

class Carrier extends Model
{
    protected $table='carrier';
    protected $primaryKey='carrier_id';
    protected $fillable=[
    	'reference_id',
    	'tax_rules_group_id',
        'name',
    	'image',
    	'url',
    	'active',
    	'deleted',
    	'shipping_handling',
    	'range_behavior',
        'is_module',
        'is_free',
        'shipping_extenal',
        'need_range',
        'external_module_name',
        'shipping_method',
        'position',
        'max_width',
        'max_height',
        'max_depth',
        'max_weight',
        'grade',
        'delay'
    ];
    public $timestamps=false;

    static function getCarrierBaseProductId($product_id)
	{
        $result = DB::table('product_to_carrier as p2c')
                    ->Join('carrier as c','c.carrier_id','p2c.carrier_id')
                    ->Where('p2c.product_id',$product_id)
                    ->OrderBy('c.name')
                    ->select('c.*')
					->get();
		return $result;
	}
}
