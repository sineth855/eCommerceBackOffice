<?php

namespace App\Http\Controllers\BackEnd\Products\AttributeGroups;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\OrderStatus\OrderStatus;
use App\Http\Models\BackEnd\Language\Language;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class AttributeGroupController extends Controller
{
    public function index()
    {

        $StockStatus=OrderStatus::AllStockStatus();

        return response()->json($StockStatus);
    }

    public function show($id){
        return response()->json([]);
    }

    public function store(Request $request)
    {

        $data=$request['data'];

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
        
        $data=$request['data'];

        return (new DataAction)->UpdateData(OrderStatus::class,$data,'order_status_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(OrderStatus::class,'order_status_id',$id);
        
    }
}
