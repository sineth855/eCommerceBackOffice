<?php

namespace App\Http\Controllers\BackEnd\Shipment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Stock\Stock;
use App\Http\Models\BackEnd\Language\Language;
use Illuminate\Support\Facades\DB;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class ShipmentController extends Controller
{

    public function index()
    {
        return $this->getOrderShipment();
    }

    public function show($id){
        $getShipment=DB::table('order_shipment')
                    ->select('customer_group_description.name as customer_group','customer.telephone as customer_telephone','customer.firstname as customer_firstname','customer.lastname as customer_lastname','customer.email as customer_email','order_status.name as order_status','order.*','shipping_courier.shipping_courier_name','order_shipment.tracking_number','order_shipment.order_shipment_id')
                    ->join('order','order.order_id','=','order_shipment.order_id')
                    ->join('shipping_courier','shipping_courier.shipping_courier_id','=','order_shipment.shipping_courier_id')
                    ->join('order_status','order_status.order_status_id','=','order.order_status_id')
                    ->join('customer_group','customer_group.customer_group_id','=','order.customer_group_id')
                    ->join('customer_group_description','customer_group.customer_group_id','=','order.customer_group_id')
                    ->join('customer','customer.customer_id','=','order.customer_id')
                    ->where('customer_group_description.language_id',config_language_id)
                    ->where('order_shipment.order_shipment_id',$id)
                    ->first();   
        $getProductOrder = DB::table('order_product')->where('order_id',$id)->get();
        return response()->json(['shipment'=>$getShipment,'order_product'=>$getProductOrder]);
    }

    public function store(Request $request)
    {


    }

    public function edit($id)
    {
        
    }

    public function update(Request $request,$id)
    {
        

    }

    public function destroy($id)
    {

        
    }
    public function undelivery()
    {
        return $this->getOrderShipment(18);
    }
    public function delivery()
    {
        return $this->getOrderShipment(19);
    }
    public function pickups()
    {
        return $this->getOrderShipment(17);
    }
    public function getOrderShipment($status='')
    {
        $sql=DB::table('v_shipment_detail')
                    ->select( '*');
        if ($status!='') {
            $sql=$sql->where('order_status_id',$status);
        }
        
        return $sql->get();
    }
    public function filterShippment(Request $request)
    {
        $filter=$request->all();
        foreach($filter as $key=>$val){
            if($val==='' or $val===null){
                unset($filter[$key]);
            }
        }
        
        $sql=DB::table('v_shipment_detail')
                    ->select( '*');
        //             ->join('order_status','order_status.order_status_id','=','order.order_status_id');
        //if ($status) {
            $sql=$sql->where($filter);
        //}
        return response()->json(['result'=>true,'data'=>$sql->get()]); 
    }

}
