<?php

namespace App\Http\Controllers\FrontEnd\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Session;

class BestSellerController extends Controller
{
    /**
     * Display a listing of the BestSeller Create On 01-02-2018
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    	 $filter_data = array(
            'order' => 'DESC',
            'limit' => 4
        );
    	$products = array();
    	$results = $this->getBestSellerProducts($filter_data);
    	if($results){
    		foreach ($results as $result) {
				$products[] = array(
					'product_id'  => $result->product_id,
					'thumb'       => $result->image,
					'name'        => $result->name,
					'description' => html_entity_decode($result->description, ENT_QUOTES, 'UTF-8'),
					// 'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $result->price,
					'special'     => $result->special,
					// 'tax'         => $result->tax,
					'rating'      => $result->rating,
					// 'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
					'href'        => 'product/product', 'product_id=' . $result->product_id
				);
    		}
    	}

    	return response()->json(['data'=>$products,'success' => true, 'message' => 'Success', 'lang'=>Session::get('applangId')]);

    }

    public function getBestSellerProducts($data = array()){
    	$product_data = array();
		$sql = DB::table('order_product')
				->SELECT('order_product.product_id',DB::raw('SUM('.env('DB_PREFIX').'order_product.quantity) as total'))
				->leftJoin('order','order.order_id','=','order.order_id')
				->leftJoin('product','order_product.product_id','=','product.product_id')
				->leftJoin('product_to_store','product.product_id','=','product_to_store.product_id')
				->where('order.order_status_id','>',0)
				->where('product.status',1)
				->where('product.date_available','<=',Carbon::today())
				->where('product_to_store.store_id',config_store_id)
				->GroupBy('order_product.product_id');
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql->OrderBy("total","DESC");
			}
			if (isset($data['limit'])) {
				$sql->Limit($data['limit']);
			}
		$query = $sql->get();
		$product_data = array();
		foreach ($query as $result) {
			$product_data[] = $this->getProduct($result->product_id);
		}
		
		return $product_data;
    }
}
