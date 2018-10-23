<?php

namespace App\Http\Controllers\FrontEnd\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Session;

class RecommandController extends Controller
{
    /**
     * Display a listing of the Recommand Product Create On 1-30-2018
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    	session_start();
    	$filter_data = array(
            'sort'  => 'p.date_added',
            'order' => 'DESC',
            'start' => 0,
            'limit' => 4
        );

        $results = $this->getRecommandProducts($filter_data);
        $productRecommanded = array();
        if($results){
            foreach ($results as $p) {
                $productRecommanded[] = array(
                    'product_id'  => $p->product_id,
                    'thumb'       => $p->image,
                    'name'        => $p->name,
                    'description' => html_entity_decode($p->description, ENT_QUOTES, 'UTF-8'),
                    'price'       => $p->price,
                    'special'     => $p->special,
                    // 'tax'         => $p->tax,
                    'rating'      => $p->rating,
                    'href'        => 'product/product', 'product_id=' . $p->product_id
                );                
            }

        }
        
        return response()->json(['data' => $productRecommanded,'success' => true, 'message' => 'Success', 'lang'=>Session::get('applangId')]);
    }

    public function getRecommandProducts($data = array()) {
		
		$sql = DB::table('product')
				->select('product.product_id',DB::raw('(SELECT AVG(rating) AS total FROM '.env('DB_PREFIX').'review r1 
				WHERE r1.product_id = '.env('DB_PREFIX').'product.product_id AND r1.status = 1
				GROUP BY r1.product_id) AS rating'),DB::raw('(SELECT price FROM '.env('DB_PREFIX').'product_discount pd2 WHERE pd2.product_id = '.env('DB_PREFIX').'product.product_id 
				AND pd2.customer_group_id = 1 AND pd2.quantity = 1  AND ((pd2.date_start = 0000-00-00
				OR pd2.date_start < NOW()) 
				AND (pd2.date_end = 0000-00-00 OR pd2.date_end > NOW())) 
				ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) 
				AS discount'),DB::raw('(SELECT price FROM '.env('DB_PREFIX').'product_special ps WHERE ps.product_id = '.env('DB_PREFIX').'product.product_id AND ps.customer_group_id = 1 AND ((ps.date_start = 0000-00-00 OR ps.date_start < NOW()) AND (ps.date_end = 0000-00-00 OR ps.date_end > NOW())) 
				ORDER BY ps.priority ASC
				, ps.price ASC LIMIT 1) AS special'))
				->leftJoin('product_description','product.product_id','=','product_description.product_id')
				->leftJoin('product_to_store','product.product_id','=','product_to_store.product_id')
				->leftJoin('review','review.product_id','=','product.product_id')
				->where('product_description.language_id',1)
				->where('product.status',1)
				->where('product.date_available','<=',Carbon::today())
				->where('product_to_store.store_id',config_store_id)
				->where('review.rating','>',0)
				->groupBy('product_description.name')
				->groupBy('product.product_id');

		if (isset($data['limit'])) {
			$sql->Limit($data['limit']);
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql->OrderBy("product_description.name","DESC");
		} else {
			$sql->OrderBy("product_description.name","ASC");
		}

		$query = $sql->get();

		$product_data = array();
		foreach ($query as $result) {
			$product_data[] = $this->getProduct($result->product_id);
		}
		return $product_data;
	}  	
}
