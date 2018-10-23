<?php

namespace App\Http\Models\BackEnd\Product;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\BackEnd\Product\ProductDescription;
use Carbon\Carbon;
use DB;

class ProductModel extends Model
{
    protected $table = 'product';
	protected $primaryKey='product_id';
	protected $fillable=[
    	'model',
		'sku',
		'upc',
		'ean',
		'jan',
		'isbn',
		'mpn',
		'location',
		'quantity',
		'stock_status_id',
		'image',
		'manufacturer_id',
		'shipping',
		'price',
		'points',
		'tax_class_id',
		'date_available',
		'weight',
		'weight_class_id',
		'length',
		'width',
		'height',
		'length_class_id',
		'subtract',
		'minimum',
		'sort_order',
		'status',
		'viewed',
		'date_added',
		'date_modified',
    ];
	public $timestamps = false;

	static function getStoreBaseProductId($product_id)
	{
        $result = DB::table('product_to_store as p2s')
                    ->Join('store as s','s.store_id','p2s.store_id')
					->Where('p2s.product_id',$product_id)
                    ->OrderBy('s.name')
                    ->select('s.*')
					->get();
		return $result;
	}

	static function UpdateOrCreate($data,$product_id='')
	{
		if (!$product_id) {
			$data['date_added']=Carbon::now();
			$data['date_modified']=Carbon::now();
			return static::insert($data);
		}else{
			$data['date_modified']=Carbon::now();
			$Product=static::find($product_id);
			if (!$Product) {
				return false;
			}
			return $Product->update($data);
		}
	}
	static function DeleteProduct($product_id)
	{
		$Product=static::find($product_id);
		$ProductDescription = ProductDescription::where('product_id',$product_id)->delete();
		if (!$Product) {
			return ['success'=>false,
					'message'=>'Data fail to delete.'];
		}
		return ['deleted'=>$Product->delete(),
    			'message'=>'Data successfully deleted.'];
	}
	public function scopeFilter($query,$filter=array())
	{
	  	foreach ($filter as $key => $value) {
	  		$query->where($key,$value);
	  	}
	  	return $query;
	  	
	}
	public function scopeSort($query,$sort='sort_order',$type='desc')
	{
	  	return $query->orderBy($sort,$type);
	}
	public function Description()
	{
		return $this->hasMany(ProductDescription::class,'product_id');
	}
	public function getDescription()
	{
		return $this->hasMany(ProductDescription::class,'product_id')->get()->toArray();
	}
	
}
