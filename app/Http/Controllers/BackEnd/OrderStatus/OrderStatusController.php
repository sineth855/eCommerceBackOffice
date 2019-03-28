<?php

namespace App\Http\Controllers\BackEnd\OrderStatus;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\OrderStatus\OrderStatus;
use App\Http\Models\BackEnd\Language\Language;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
use Cache;
use DB;
use Response;

class OrderStatusController extends Controller
{
    public function index()
    {   
        // $value = Cache::rememberForever('users', function() {
        //     return DB::table('users')->get();
        // });

        // $allproducts = Cache::remember('allproducts',60, function() {
        //     return DB::table('users')->get();
        // });
        // $alluser = '';
        // if( Cache::has( 'users' ) ) {
        //     return $alluser = Cache::get( 'users' );
        //   }
        // dd($alluser);
    //    $data = Cache::remember('articles', 15, function() {
    //         return OrderStatus::all();
    //     });
        
        // $StockStatus=OrderStatus::AllStockStatus();
        // Cache::put('007', $StockStatus, 60);
        // Cache::remember('OrderStatus', 15, function() {
        //     return OrderStatus::all();
        // });
        // dd(Cache::get('007'));
        // #####################
        
        // $response_data = array();
        // $response_code = 200;

        // // TRY TO RETURN A CACHED RESPONSE
        // $cache_key = "gallery_index";
        // $response_data = Cache::get($cache_key, null);

        // // IF NO CACHED RESPONSE, QUERY THE DATABASE
        // if (!$response_data) {
        //     try {
        //         $response_data['items'] = OrderStatus::AllStockStatus();
        //         Cache::put($cache_key, $response_data, 60);
        //     } catch (PDOException $ex) {
        //         $response_code = 500;
        //         $response_data['error'] = ErrorReporter::raiseError($ex->getCode());
        //     }
        // }

        // return Response::json($response_data, $response_code);
        // ####################
        $StockStatus=OrderStatus::AllStockStatus();
        return response()->json(['success'=>true,'data'=>$StockStatus,'total'=>count($StockStatus)]);
    }

    public function show($id){
        return response()->json([]);
    }

    public function store(Request $request)
    {

        $data=(new OrderStatus)->getFillable();
        $data=$request->only($data);
        $data['language_id'] = config_language_id;
        $condition=[
            'name'=>$data['name']
        ];

        return (new DataAction)->StoreData(OrderStatus::class,$condition,'',$data);

    }

    public function edit($id)
    {
        return (new DataAction)->EditData(OrderStatus::class,$id);
        
    }

    public function update(Request $request,$id)
    {
        
        $data=(new OrderStatus)->getFillable();
        $data=$request->only($data);

        return (new DataAction)->UpdateData(OrderStatus::class,$data,'order_status_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(OrderStatus::class,'order_status_id',$id);
        
    }
    
}
