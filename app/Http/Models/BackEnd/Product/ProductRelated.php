<?php

namespace App\Http\Models\BackEnd\product;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductRelated extends Model
{
    protected $table = 'product_related';
    
    protected $fillable=[
    	'product_id',
		'related_id',
    ];
    public $timestamps = false;

    static function getRalatedProductBaseProductId($product_id)
	{
        $result = DB::table('product_related as pr')
                    ->Join('product as p','p.product_id','pr.related_id')
					->Join('product_description as pd','pd.product_id','p.product_id')
                    ->Where('pd.language_id',config_language_id)
					->Where('pr.product_id',$product_id)
                    ->OrderBy('pd.name')
                    ->select('pd.*')
					->get();
		return $result;
	}
}
