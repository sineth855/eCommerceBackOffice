<?php

namespace App\Http\Controllers\FrontEnd\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Session;

class FillterController extends Controller
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

}
