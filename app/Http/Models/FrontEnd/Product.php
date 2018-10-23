<?php

namespace App\Http\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;
use DB;
class Product extends Model
{
    protected $table = 'product';
	protected $primaryKey='product_id';
	protected $fillable = [
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
		'date_modified'
	];
	public $timestamps = false;


	static function getProductOptions($product_id) {
		$product_option_data = array();

		$product_option_query = DB::table('product_option as po')
								->select('*')
								->leftjoin('option as o','po.option_id','=','o.option_id')
								->leftjoin('option_description as od','o.option_id','=','od.option_id')
								->where('po.product_id',$product_id)
								->where('od.language_id',config_language_id)
								->orderBy('o.sort_order')
								->get();
		//dd($product_option_query);
		// $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po 
		// LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) 
		// LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) 
		// WHERE po.product_id = '" . (int)$product_id . "' 
		// AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' 
		// ORDER BY o.sort_order");

		foreach ($product_option_query as $product_option) {
			$product_option_value_data = array();

			$product_option_value_query = DB::table('product_option_value as pov')
										  ->select('*')
										  ->leftjoin('option_value as ov','pov.option_value_id','=','ov.option_value_id')
										  ->leftjoin('option_value_description as ovd','ov.option_value_id','=','ovd.option_value_id')
										  ->where('pov.product_id',$product_id)
										  ->where('pov.product_option_id',$product_option->product_option_id)
										  ->where('ovd.language_id',config_language_id)
										  ->orderBy('ov.sort_order')
										  ->get();
			// dd($product_option_value_query);
			// $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov 
			// LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) 
			// LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = 
			// ovd.option_value_id) 
			// WHERE pov.product_id = '" . (int)$product_id . "' 
			// AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' 
			// AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			// ORDER BY ov.sort_order");
			foreach ($product_option_value_query as $product_option_value) {
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value->product_option_value_id,
					'option_value_id'         => $product_option_value->option_value_id,
					// this value take place when option == color&texture
					'value'	  				  => $product_option_value->value,
					'name'                    => $product_option_value->name,
					'image'                   => $product_option_value->image,
					'quantity'                => $product_option_value->quantity,
					'option_size_id'          => $product_option_value->option_size_id,
					'is_instock'              => $product_option_value->is_instock,
					'subtract'                => $product_option_value->subtract,
					'price'                   => $product_option_value->price,
					'price_prefix'            => $product_option_value->price_prefix,
					'weight'                  => $product_option_value->weight,
					'weight_prefix'           => $product_option_value->weight_prefix
				);
			}

			$product_option_data[] = array(
				'product_option_id'    => $product_option->product_option_id,
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option->option_id,
				'name'                 => $product_option->name,
				'type'                 => $product_option->type,
				'value'                => $product_option->value,
				'required'             => $product_option->required
			);
		}

		return $product_option_data;
	}
}
