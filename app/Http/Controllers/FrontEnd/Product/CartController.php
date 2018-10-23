<?php namespace App\Http\Controllers\FrontEnd\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\FrontEnd\Cart;
use App\Http\Models\FrontEnd\Category;
use App\Http\Models\FrontEnd\Customer;
use App\Http\Models\FrontEnd\Product;
use App\Http\Models\FrontEnd\ProductDescription;
use App\Http\Models\FrontEnd\SessionModel;
use App\Http\Models\FrontEnd\Order\OrderModel;
use App\Http\Models\FrontEnd\Order\OrderHistory;
use App\Http\Models\FrontEnd\Order\OrderOption;
use App\Http\Models\FrontEnd\Order\OrderProduct;
use App\Http\Models\FrontEnd\Order\OrderShipment;
use App\Http\Models\FrontEnd\Order\OrderStatus;
use App\Http\Models\FrontEnd\Order\OrderTotal;
use App\Http\Models\FrontEnd\Order\ShippingCourier;
use App\http\models\commons\Location\Country;
use App\http\models\commons\Location\GeoZone;
use App\http\models\commons\Location\Zone;
use App\http\models\commons\Location\ZoneToGeoZone;

use Illuminate\Support\Facades\Input;
use DB;
use App\user;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use rules;
use Redirect;
use View;

class CartController extends Controller
{   
    public function __construct()
    {   
        // $this->middleware(function ($request, $next) {
        //  // dd(Auth::check());
        //     SessionModel::AddSession();
        //     $data['MyCart']=SessionModel::find(session()->getId())->Cart()->get();
        //     //dd($data);
        //     View::share($data);
        //     return $next($request);
        // });   
    } 

    public function index()
    {
        header('Access-Control-Allow-Origin: *');
        return view('frontend.index');
    }

    public function AddToCart(Request $request)
    {
       return Cart::AddToCart($request->all());
    }
    public function RemoveFromCart(Request $request)
    {
       return Cart::RemoveFromCart($request->all());
    }
    public function UpdateCart(Request $request)
    {
        return Cart::UpdateCart($request->all());
    }
    public function ProductCart(Request $request)
    {
        $input = $request->all();
        $datas['TotalPrices']=0;
        $datas['session_id']=$input['session_id'];
        if (Auth::guard('account')->id()) {
            $datas['data']=DB::table('cart')
                            ->select('product.*','cart.quantity as cart_quantity')
                            ->join('product','product.product_id','=','cart.product_id')
                            ->where('cart.customer_id',Auth::guard('account')->id())
                            ->get();
        }else{
            $datas['data'] = DB::table('cart')
                                ->select('product.*','cart.quantity as cart_quantity')
                                ->join('product','product.product_id','=','cart.product_id')
                                ->where('cart.session_id',$input['session_id'])
                                ->get();
        }

        foreach ($datas['data'] as $key => $value) {
            $value->name=ProductDescription::findOrfail($value->product_id)
                        ->where('product_id',$value->product_id)
                        ->where('language_id',config_language_id)
                        ->value('name');
                        
            $datas['TotalPrices']+=$value->cart_quantity*$value->price;
        }
        $datas['data']=$datas['data']->toArray();
        return $datas;
    }

    
    public function Checkout(Request $request)
    {
        $request['firstname']='sineth';
        $request['lastname']='sineth';
        $request['email']='simsineth855@gmail.com';
        $request['invoice_no']='00001';
        $request['invoice_prefix']='cc_';
        $request['store_id']=0;
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

        $request['code']=0;
        $request['title']=0;

        $data = (new OrderTotal)->getFillable();
        $data = $request->only($data);
        OrderTotal::insert($data);
    }
}
