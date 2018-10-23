<?php

namespace App\Http\Controllers\FrontEnd\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\FrontEnd\Product;
use App\Http\Models\FrontEnd\Product\Review;
use App\Http\Models\FrontEnd\Category;
use DB;
use Carbon\Carbon;
use Session;

class ProductController extends Controller
{

    public function index($id,$category_id=0){
		// dd(bcrypt("test"));
    	// Get Info product Details
		$productInfo = $this->getProductByCategory($id,$category_id);
		$filter_data = array(
			'store_id'      => config_store_id
		);
		$category_info = Category::getCategory($category_id,$filter_data);
		// Get product image
		$images = array();
		$results = $this->getProductImages($id);
		foreach ($results as $result) {
			$images[] = array(
				'image' => $result->image
			);
		}
		//Get Attribute group
		$attribute_groups = $this->getProductAttributes($id);
		// Get DiscountProduct
		$discounts = $this->getProductDiscounts($id);
		$discount_arr = array();
		foreach ($discounts as $discount) {
			$discount_arr[] = array(
				'quantity' => $discount->quantity,
				'price' => $discount->price
			);
		}
		// Review
		if ($productInfo->minimum) {
			$minimum = $productInfo->minimum;
		} else {
			$minimum = 1;
		}
		// Review
		$review_status = config_review_status;
		//$reviews = sprintf("Review", ((int)$productInfo->reviews));
		$reviews = ((int)$productInfo->reviews)." "."Review";
		$rating = (int)$productInfo->rating;
		// Product relate
		$product_related = array();

		$results = $this->getProductRelated($id);
		// dd($results);
		foreach ($results as $result) {
			// if ($result->image) {
			// 	$image = $result->image;
			// } else {
			// 	$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
			// }

			//if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
			// if (config_customer_price) {
			// 	$price = $result->price;//$this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			// } else {
			// 	$price = '';
			// }

			if (isset($result->special)) {
				$special = $result->special;//$this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$special = null;
			}

			// if ($this->config->get('config_tax')) {
			// 	$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
			// } else {
			// 	$tax = false;
			// }

			if (config_review_status) {
				$rating = $result->rating;
			} else {
				$rating = false;
			}

			$product_related[] = array(
				'product_id'  => $result->product_id,
				'thumb'       => $result->image,
				'name'        => $result->name,
				'description' => html_entity_decode($result->description, ENT_QUOTES, 'UTF-8'),
				'price'       => $result->price,
				'special'     => $special,
				// 'tax'         => $tax,
				'minimum'     => $result->minimum > 0 ? $result->minimum : 1,
				'rating'      => $rating,
				'href'        => 'product/product', 'product_id=' . $result->product_id
			);
		}

		$getProductOptions = $this->getProductOptions($id);
		// dd($getProductOptions);
		return response()->json(['data' => $productInfo,'category_info'=>$category_info,'option_value' => $getProductOptions,'images'=>$images,'attribute_groups' => $attribute_groups,'discount' => $discount_arr,'product_relate' => $product_related,'review_status' => $review_status,'reviews' => $reviews,'success' => true, 'message' => 'Success', 'lang'=>Session::get('applangId')]);

	}
	
	public function getProductByCategory($product_id,$category_id) {
		$query = DB::table('product')
				->select(DB::raw('DISTINCT *'),'product.product_id','product_description.name as name','product.image','manufacturer.name AS manufacturer',DB::raw('(SELECT price FROM sg_product_discount pd2 WHERE pd2.product_id = sg_product.product_id AND pd2.customer_group_id = 1 AND pd2.quantity = 1 AND ((pd2.date_start = 0000-00-00 OR pd2.date_start < NOW()) AND (pd2.date_end = 0000-00-00 OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC
						, pd2.price ASC LIMIT 1) AS discount'),DB::raw('(SELECT price FROM sg_product_special ps WHERE ps.product_id = sg_product.product_id AND ps.customer_group_id = 1 AND ((ps.date_start = 0000-00-00 OR ps.date_start < NOW()) AND (ps.date_end = 0000-00-00 OR ps.date_end > NOW())) ORDER BY ps.priority ASC
						, ps.price ASC LIMIT 1) AS special'),DB::raw('(SELECT points FROM sg_product_reward pr WHERE pr.product_id = sg_product.product_id AND customer_group_id = 1) AS reward'),DB::raw('(SELECT ss.name FROM sg_stock_status ss WHERE ss.stock_status_id = sg_product.stock_status_id AND ss.language_id = 1 ) AS stock_status'),DB::raw('(SELECT wcd.unit FROM sg_weight_class_description wcd WHERE sg_product.weight_class_id = wcd.weight_class_id AND wcd.language_id = 1 ) AS weight_class'),DB::raw('(SELECT lcd.unit FROM sg_length_class_description lcd WHERE sg_product.length_class_id = lcd.length_class_id AND lcd.language_id = 1 ) AS length_class'),DB::raw('(SELECT AVG(rating) AS total FROM sg_review r1 WHERE r1.product_id = sg_product.product_id AND r1.status = 1 GROUP BY r1.product_id) AS rating'),DB::raw('(SELECT COUNT(*) AS total FROM sg_review r2 WHERE r2.product_id = sg_product.product_id AND r2.status = 1 GROUP BY r2.product_id) AS reviews'),'product.sort_order')
				->leftJoin('product_description','product.product_id','=','product_description.product_id')
				->leftJoin('product_to_store','product.product_id','=','product_to_store.product_id')
				->leftJoin('manufacturer','manufacturer.manufacturer_id','=','product.manufacturer_id')
				->join('product_to_category','product.product_id','=','product_to_category.product_id')
				// ->join('category','category.category_id',$category_id)
				// ->join('category_description','category_description.category_id',$category_id)
				// ->where('category_description.language_id',1)
				->where('product.product_id',$product_id)
				->where('product_description.language_id',1)
				->where('product.status',1)
				->where('product.date_available','<=',Carbon::today())
				->where('product_to_store.store_id',config_store_id);
		if($category_id>0){
			$query->where('product_to_category.category_id',$category_id);
		}
		return($query->first());
	}

	public function product_review(Request $request){
		$input = $request->all();
		$input['customer_id']=0;
		$input['date_added'] = '2017-02-02';
		$input['date_modified'] = '2017-02-02';
		$input['status']=1;
		Review::create($input);
		return response()->json(['request'=>$request->all(),'success' => true, 'message' => 'Review has been submitted.'], 200);
	}
    
    public function getProductDiscounts($product_id) {
		$query = DB::select("SELECT * FROM ".env('DB_PREFIX')."product_discount 
				WHERE product_id = '".(int)$product_id."'
				AND customer_group_id = '".config_customer_group_id."'
				AND quantity > 1 
				AND ((date_start = '0000-00-00' OR date_start < NOW()) 
				AND (date_end = '0000-00-00' OR date_end > NOW())) 
				ORDER BY quantity ASC, priority ASC, price ASC");
		return $query;
	}

	public function getProductImages($product_id) {
		$query = DB::table("product_image")
				->where("product_id",$product_id)
				->orderBy('sort_order','asc')
				->get();
		return $query;
	}

	public function getProductAttributes($product_id) {
		$product_attribute_group_data = array();
		$product_attribute_group_query = DB::select("SELECT ag.attribute_group_id, agd.name 
										FROM ".env('DB_PREFIX')."product_attribute pa 
										LEFT JOIN ".env('DB_PREFIX')."attribute a ON (pa.attribute_id = a.attribute_id) 
										LEFT JOIN ".env('DB_PREFIX')."attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) 
										LEFT JOIN ".env('DB_PREFIX')."attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) 
										WHERE pa.product_id = '".(int)$product_id."'
										AND agd.language_id = '".config_language_id."'
										ORDER BY ag.sort_order, agd.name");

		foreach ($product_attribute_group_query as $product_attribute_group) {
			$product_attribute_data = array();

			$product_attribute_query = DB::select("SELECT a.attribute_id, ad.name, pa.text FROM ".env('DB_PREFIX')."product_attribute pa LEFT JOIN ".env('DB_PREFIX')."attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN ".env('DB_PREFIX')."attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group->attribute_group_id . "' AND ad.language_id = '" . config_language_id . "' AND pa.language_id = '" . config_language_id . "' ORDER BY a.sort_order, ad.name");

			foreach ($product_attribute_query as $product_attribute) {
				$product_attribute_data[] = array(
					'attribute_id' => $product_attribute->attribute_id,
					'name'         => $product_attribute->name,
					'text'         => $product_attribute->text
				);
			}

			$product_attribute_group_data[] = array(
				'attribute_group_id' => $product_attribute_group->attribute_group_id,
				'name'               => $product_attribute_group->name,
				'attribute'          => $product_attribute_data
			);
		}
		return $product_attribute_group_data;
	}

	public function getProductRelated($product_id) {
		$product_data = array();
		// $query = DB::select("SELECT * FROM ".env('DB_PREFIX')."product_related pr 
		// 					LEFT JOIN ".env('DB_PREFIX')."product p ON (pr.related_id = p.product_id) 
		// 					LEFT JOIN ".env('DB_PREFIX')."product_to_store p2s ON (p.product_id = p2s.product_id) 
		// 					WHERE pr.product_id = '".(int)$product_id."'
		// 					AND p.status = '1' 
		// 					AND p.date_available <= NOW() 
		// 					AND p2s.store_id = '".config_store_id."'
		// 					");
		$query = DB::table('product_related as pr')
				->select('*',DB::raw('(SELECT ps.price FROM sg_product_special ps WHERE ps.product_id = '.(int)$product_id.' AND ps.customer_group_id = 1 AND ((ps.date_start = 0000-00-00 OR ps.date_start < NOW()) AND (ps.date_end = 0000-00-00 OR ps.date_end > NOW())) ORDER BY ps.priority ASC
				, ps.price ASC LIMIT 1) AS special'))
				->leftJoin("product as p","pr.related_id", "=", "p.product_id") 
				->leftJoin("product_to_store as p2s","p.product_id", "=", "p2s.product_id") 
				->where("pr.product_id",(int)$product_id)
				->where('p.status',1)
				->where('p.date_available', '<=' ,NOW())
				->where('p2s.store_id',config_store_id)
				->get();

		foreach ($query as $result) {
			$product_data[$result->related_id] = $this->getProduct($result->related_id);
		}
		return $product_data;

		foreach ($query as $result) {
			$product_data[$result->related_id] = $this->getProduct($result->related_id);
		}
		return $product_data;
	}

	public function getProductOptions($product_id){
		$data['options'] = array();
		// dd(Product::getProductOptions($product_id));
		foreach (Product::getProductOptions($product_id) as $option) {
			$product_option_value_data = array();
			foreach ($option['product_option_value'] as $option_value) {
				// dd($product_option_value_id);
				if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {

					//if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
					if (config_customer_price) {

						$price = 0;//$this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);

					} else {

						$price = false;

					}
					$product_option_value_data[] = array(

						'product_option_value_id' => $option_value['product_option_value_id'],

						'option_value_id'         => $option_value['option_value_id'],

						'name'                    => $option_value['name'],
						// this value take place when option == color&texture
						'value'					  => $option_value['value'],
						'image'                   => 'image',//$this->model_tool_image->resize($option_value->image, 50, 50),
						'option_size_id'				=> $option_value['option_size_id'],
						'is_instock'				=> $option_value['is_instock'],

						'price'                   => $price,

						'price_prefix'            => $option_value['price_prefix']

					);

				}

			}

			$data['options'][] = array(

				'product_option_id'    => $option['product_option_id'],

				'product_option_value' => $product_option_value_data,

				'option_id'            => $option['option_id'],

				'name'                 => $option['name'],

				'type'                 => $option['type'],

				'value'                => $option['value'],

				'required'             => $option['required']

			);

		}
		return $data;
	}
}
