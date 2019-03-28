<?php

namespace App\Http\Controllers\BackEnd\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Order\OrderModel;
use App\Http\Models\BackEnd\Order\OrderHistory;
use App\Http\Models\BackEnd\Order\OrderOption;
use App\Http\Models\BackEnd\Order\OrderProduct;
use App\Http\Models\BackEnd\Order\OrderShipment;
use App\Http\Models\BackEnd\Order\OrderTotal;
use App\Http\Models\BackEnd\Order\OrderPayment;
use App\Http\Models\BackEnd\Order\ShippingCourier;
use App\Http\Models\BackEnd\OrderStatus\OrderStatus;
use App\Http\Controllers\BackEnd\commons\CommonsController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\BackEnd\CustomerGroup\CustomerGroupDescription\CustomerGroupDescription;

class SaleOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Orders = OrderModel::where('store_id', config_store_id)->get();
        $data = array();
        foreach($Orders as $order){
            $data[] = array(
                'order_id' => $order->order_id,
                'invoice_prefix' => $order->invoice_prefix,
                'store_name' => $order->store_name,
                'payment_firstname' => $order->payment_firstname,
                'payment_lastname' => $order->payment_lastname,
                'email' => $order->email,
                'telephone' => $order->telephone,
                'status' => $order->OrderStatus->name
            );
        }
        return response()->json(['success'=>true,'data'=>$data,'total'=>count($data)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $select['stores']=$this->getStores();
        $select['currencies']=$this->getCurrencies();
        $select['customergroups']=$this->getCustomerGroups();
        $select['productlists']=array_pluck($this->getProducts(), 'name', 'product_id');
        // $select['']=
        // $select['']=
        // dd($select);
        return $select;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['firstname']='sineth';
        $request['lastname']='sineth';
        $request['email']='simsineth855@gmail.com';
        $request['store_id']=0;
        $request['invoice_no']='00001';
        $request['invoice_prefix']='cc_';
        $request['store_name']='test';
        $request['store_url']='test';
        $request['customer_id']=0;
        $request['customer_group_id']=0;
        $request['order_status_id']=0;
        $request['affiliate_id']=0;
        $request['commission']=0;
        $request['marketing_id']=0;
        $request['tracking']=0;
        $request['language_id']=2;
        $request['currency_id']=1;
        $request['currency_code']='$';
        $request['currency_value']='2';
        $request['name']='test';
        $request['accept_language']=2;
        $request['reward']='8438';
        $request['ip']=$request->ip();
        $request['forwarded_ip']=$request->ip();
        $request['user_agent']=$request->server('HTTP_USER_AGENT');
        $request['date_added']=date('Y-m-d');
        $request['date_modified']=date('Y-m-d');
        $request['total']=$this->ProductCart()['TotalPrices'];
        if (isset($request['payment_country_id']) && $request['payment_country_id']) {
            $request['payment_country']=Country::find($request['payment_country_id'])->value('name');
        }
        if (isset($request['payment_zone_id']) && $request['payment_zone_id']) {
            $request['payment_zone']=Zone::find($request['payment_zone_id'])->value('name');
        }
        if (isset($request['shipping_country_id']) && $request['shipping_country_id']) {
            $request['shipping_country']=Country::find($request['shipping_country_id'])->value('name');
        }
        if (isset($request['shipping_zone_id']) && $request['shipping_zone_id']) {
            $request['shipping_zone']=Zone::find($request['shipping_zone_id'])->value('name');
        }
        

        // return $request;

        $order = (new OrderModel)->getFillable();
        $order = $request->only($order);
        $orderId=OrderModel::insertGetId($order);

        $request['order_id']=$orderId;

        $request['order_status_id']=1;

        $data = (new OrderHistory)->getFillable();
        $data = $request->only($data);
        OrderHistory::insert($data);


        foreach ($this->ProductCart()['data'] as $product) {
            foreach ($product as $key => $value) {
                $request[$key]=$value;
            }

            $data = (new OrderProduct)->getFillable();
            $data = $request->only($data);
            $OrderProductId=OrderProduct::insertGetId($data);
            $request['order_product_id']=$OrderProductId;
            $request['product_option_id']=0;
            $request['value']=0;
            $request['type']=0;
                
            $data = (new OrderOption)->getFillable();
            $data = $request->only($data);
            OrderOption::insert($data);
        }

        $data = (new OrderShipment)->getFillable();
        $data = $request->only($data);
        OrderShipment::insert($data);

        $request['code'] = 0;
        $request['title'] = 0;

        $data = (new OrderTotal)->getFillable();
        $data = $request->only($data);
        OrderTotal::insert($data);
    }

    public function createOrderPayment(Request $request){
        $OrderPayment = OrderPayment::create([
            'order_id' => $request['order_id'],
            'currency_id' => $request['currency_id'],
            'amount' => $request['amount'],
            'payment_method' => $request['payment_method'],
            'conversion_rate' => '0.00',
            'transaction_id' => $request['transaction_id'],
            'card_number' => '',
            'card_brand' => '',
            'card_expiration' => '',
            'card_holder' => '',
            'remark' => $request['remark'],
            'date_add' => date('Y-m-d')
        ]);
        return response()->json(['success' => true,'message' => 'Payment has been created.']);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('order as o')
                    ->Join('order_status as os','o.order_status_id','=','os.order_status_id')
                    ->Join('shipping_courier as sc','o.shipping_courier_id','=','sc.shipping_courier_id')
                    ->Join('customer_group_description as cgd','o.customer_group_id','=','cgd.customer_group_id')
                    ->select('o.*','os.name as order_status','sc.shipping_courier_name as shipping_name','cgd.name as customer_group_name')
                    ->where('order_id','=',$id)
                    ->where('o.store_id', config_store_id)
                    ->first();
        // dd($data);
        //$data=OrderModel::find($id);

        $data->customer_group_name=CustomerGroupDescription::find($data->customer_group_id)->value('name');
        $result['data']=$data;
        $result['order_history']=OrderHistory::where('order_id',$data->order_id)->get();
        $result['order_status']=OrderStatus::where('language_id',1)->pluck('name','order_status_id');
        $result['select_status']=OrderStatus::where('language_id',1)->select(['order_status_id as value','name as text'])->get();
        $result['products']=OrderProduct::where('order_id',$data->order_id)->get();
        $result['sub_total']=OrderProduct::where('order_id',$data->order_id)->sum('total');
        $result['tax']=OrderProduct::where('order_id',$data->order_id)->sum('tax');
        $result['total']=OrderProduct::where('order_id',$data->order_id)->sum('total')+OrderProduct::where('order_id',$data->order_id)->sum('tax');
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = OrderModel::where('order_id',$id)->where('store_id', config_store_id)->get();
        $data['products'] = OrderProduct::getProductBaseOrder($id, config_store_id);
        $data['shipment'] = OrderModel::getCarrierBaseOrder($id, config_store_id);
        $data['order_payment'] = OrderModel::getPaymentByOrder($id, config_store_id);
        return response()->json(['success' => true,'data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return (new DataAction)->DeleteData(User::class,'id',$id);
    }
}
