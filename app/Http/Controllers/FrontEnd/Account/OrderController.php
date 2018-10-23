<?php

namespace App\Http\Controllers\FrontEnd\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;
use Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the BestSeller Create On 01-02-2018
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    	if(Auth::guard('account')->id()){
            $Orders = $this->getOrders((int)Auth::guard('account')->id(),config_store_id);
    		return response()->json(['data'=>$Orders,'success' => true, 'message' => 'Success', 'lang'=>Session::get('applangId')]);
        }else{
          	return response()->json(['success' => false, 'message' => 'Unauthorise']);
        }
    }

    public function show($id){
        $Order = $this->getOrder($id);
        $OrderProducts = $this->getOrderProducts($id);
        return response()->json(['data'=>$Order,'order_product'=>$OrderProducts,'success' => true, 'message' => 'Success', 'lang'=>Session::get('applangId')]);
    }

    public function getOrders($customer_id,$config_store_id){
        $Orders = DB::table('order as o')
                    ->select('o.order_id', 'o.firstname', 'o.lastname', 'os.name as status', 'o.date_added', 'o.total', 'o.currency_code', 'o.currency_value')
                    ->Join('order_status as os','o.order_status_id','=','os.order_status_id')
                    ->where('o.customer_id',''.(int)$customer_id.'')
                    ->where('o.order_status_id','>','0')
                    ->where('o.store_id',''.$config_store_id.'')
                    ->get();

        $data = array();
        foreach ($Orders as $Order) {
            $data[] = array(
                        'order_id'=>$Order->order_id,
                        'firstname'=>$Order->firstname,
                        'status'=>$Order->status,
                        'date_added'=>$Order->date_added,
                        'currency_code'=>$Order->currency_code,
                        'currency_value'=>$Order->currency_value,
                        'total_product'=>$this->getTotalOrderProducts($Order->order_id),
                        'total'=>$Order->total,
                      );
        }
        return $data;
    }

    public function getOrder($order_id){
        $Orders = DB::table('order')
                    ->where('order_id',''.(int)$order_id.'')
                    ->where('order_status_id','>','0')
                    ->first();

        $data = array();
        $data[] = array(
                    'order_id'                => $Orders->order_id,

                    'invoice_no'              => $Orders->invoice_no,

                    'invoice_prefix'          => $Orders->invoice_prefix,

                    'store_id'                => $Orders->store_id,

                    'store_name'              => $Orders->store_name,

                    'store_url'               => $Orders->store_url,

                    'customer_id'             => $Orders->customer_id,

                    'firstname'               => $Orders->firstname,

                    'lastname'                => $Orders->lastname,

                    'telephone'               => $Orders->telephone,

                    'fax'                     => $Orders->fax,

                    'email'                   => $Orders->email,

                    'payment_firstname'       => $Orders->payment_firstname,

                    'payment_lastname'        => $Orders->payment_lastname,

                    'payment_company'         => $Orders->payment_company,

                    'payment_address_1'       => $Orders->payment_address_1,

                    'payment_address_2'       => $Orders->payment_address_2,

                    'payment_postcode'        => $Orders->payment_postcode,

                    'payment_city'            => $Orders->payment_city,

                    'payment_zone_id'         => $Orders->payment_zone_id,

                    'payment_zone'            => $Orders->payment_zone,

                    // 'payment_zone_code'       => $payment_zone_code,

                    'payment_country_id'      => $Orders->payment_country_id,

                    'payment_country'         => $Orders->payment_country,

                    // 'payment_iso_code_2'      => $payment_iso_code_2,

                    // 'payment_iso_code_3'      => $payment_iso_code_3,

                    'payment_address_format'  => $Orders->payment_address_format,

                    'payment_method'          => $Orders->payment_method,

                    'shipping_firstname'      => $Orders->shipping_firstname,

                    'shipping_lastname'       => $Orders->shipping_lastname,

                    'shipping_company'        => $Orders->shipping_company,

                    'shipping_address_1'      => $Orders->shipping_address_1,

                    'shipping_address_2'      => $Orders->shipping_address_2,

                    'shipping_postcode'       => $Orders->shipping_postcode,

                    'shipping_city'           => $Orders->shipping_city,

                    'shipping_zone_id'        => $Orders->shipping_zone_id,

                    'shipping_zone'           => $Orders->shipping_zone,

                    // 'shipping_zone_code'      => $shipping_zone_code,

                    'shipping_country_id'     => $Orders->shipping_country_id,

                    'shipping_country'        => $Orders->shipping_country,

                    // 'shipping_iso_code_2'     => $shipping_iso_code_2,

                    // 'shipping_iso_code_3'     => $shipping_iso_code_3,

                    'shipping_address_format' => $Orders->shipping_address_format,

                    'shipping_method'         => $Orders->shipping_method,

                    'comment'                 => $Orders->comment,

                    'total'                   => $Orders->total,

                    'order_status_id'         => $Orders->order_status_id,

                    'language_id'             => $Orders->language_id,

                    'currency_id'             => $Orders->currency_id,

                    'currency_code'           => $Orders->currency_code,

                    'currency_value'          => $Orders->currency_value,

                    'date_modified'           => $Orders->date_modified,

                    'date_added'              => $Orders->date_added,

                    'ip'                      => $Orders->ip
                  );
        
        return $data;
    }

    public function getOrderProducts($order_id){
        $OrderProducts = DB::table("order_product as op")
                         ->select('op.*','p.image')
                         ->join('product as p','p.product_id','=','op.product_id')
                         ->where('op.order_id',$order_id)
                         ->get();
        $data = array();
        foreach ($OrderProducts as $OrderProduct) {
            $data[] = array(
                        'product_id'=>$OrderProduct->product_id,
                        'name'=>$OrderProduct->name,
                        'image'=>$OrderProduct->image,
                        'model'=>$OrderProduct->model,
                        'quantity'=>$OrderProduct->quantity,
                        'price'=>$OrderProduct->price,
                        'total'=>$OrderProduct->total,
                        'tax'=>$OrderProduct->tax,
                        'reward'=>$OrderProduct->reward
                      );
        }

        return $data;
    }

    public function getTotalOrderProducts($order_id){
        $TotalOrderProducts = DB::table('order_product')->Where('order_id',$order_id)->count();
        return $TotalOrderProducts;
    }
}   
    