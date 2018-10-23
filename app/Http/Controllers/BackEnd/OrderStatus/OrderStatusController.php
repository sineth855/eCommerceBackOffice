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
class OrderStatusController extends Controller
{
    public function index()
    {

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
