<?php

namespace App\Http\Controllers\BackEnd\CreditOptions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\CreditOption\CreditTypeValue;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class CreditTypeValuesController extends Controller
{
    public function index()
    {

        $CreditTypeValue=CreditTypeValue::AllCreditTypeValue();
        return response()->json(['success'=>true,'data'=>$CreditTypeValue,'total'=>count($CreditTypeValue)]);
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

        return (new DataAction)->StoreData(CreditTypeValue::class,$condition,'',$data);

    }

    public function edit($id)
    {
        return (new DataAction)->EditData(CreditTypeValue::class,$id);
        
    }

    public function update(Request $request,$id)
    {
        
        $data=$request['data'];

        return (new DataAction)->UpdateData(CreditTypeValue::class,$data,'credit_type_value_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(CreditTypeValue::class,'credit_type_value_id',$id);
        
    }
}
