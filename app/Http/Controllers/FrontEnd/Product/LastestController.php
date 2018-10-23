<?php

namespace App\Http\Controllers\FrontEnd\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class LastestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        
    } 

    public function index()
    {
        session_start();
        // if(isset($_SESSION["account_id"])){
        //     dd("see it");
        // }else{
        //   dd("dont see it");  
        // }
        
        $filter_data = array(
            'sort'  => 'p.date_added',
            'order' => 'DESC',
            'start' => 0,
            'limit' => 4
            // 'limit' => $setting['limit']
        );

        $results = $this->getProducts($filter_data);        
        $products = array();
        if($results){
            foreach ($results as $p) {
                // $products = array();
                // foreach($rs as $p){
                    $products[] = array(
                        'product_id'  => $p->product_id,
                        'thumb'       => $p->image,
                        'name'        => $p->name,
                        // 'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                        'description' => html_entity_decode($p->description, ENT_QUOTES, 'UTF-8'),
                        'price'       => $p->price,
                        'special'     => $p->special,
                        // 'tax'         => $p->tax,
                        'rating'      => $p->rating
                        // 'href'        => $this->url->link('product/product', 'product_id=' . $p->product_id)
                    );
                // }   
            }

        }
        
        // dd($products);
        return response()->json(['data' => $products,'success' => true, 'message' => 'Success', 'lang'=>Session::get('applangId')]);
    }
}
