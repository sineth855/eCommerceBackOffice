<?php

namespace App\Http\Controllers\BackEnd\Stocks;

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
class StocksController extends Controller
{

    public function index()
    {
        $StockStatus=Stock::all();
        return response()->json(['success'=>true,'data'=>$StockStatus,'total'=>count($StockStatus)]);
    }

    public function show($id){
        return response()->json([]);
    }

    public function store(Request $request)
    {
        $data=(new Stock)->getFillable();
        $data=$request->only($data);
        $data['language_id'] = config_language_id;
        $condition=[
            'name'=>$data['name'],
            'language_id'=>config_language_id
        ];

        return (new DataAction)->StoreData(Stock::class,$condition,'',$data);

    }

    public function edit($id)
    {
        return (new DataAction)->EditData(Stock::class,$id);
        
    }

    public function update(Request $request,$id)
    {
        
        $data=(new Stock)->getFillable();
        $data=$request->only($data);

        return (new DataAction)->UpdateData(Stock::class,$data,'stock_status_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(Stock::class,'stock_status_id',$id);
        
    }

}
