<?php

namespace App\Http\Controllers\BackEnd\CreditOptions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\CreditOption\CreditType;
use App\Http\Models\BackEnd\CreditOption\CreditTypeValue;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class CreditTypesController extends Controller
{
    public function index()
    {

        $CreditType=CreditType::AllCreditType();
        return response()->json(['success'=>true,'data'=>$CreditType,'total'=>count($CreditType)]);
    }

    public function show($id){
        return response()->json([]);
    }

    public function store(Request $request)
    {
        //get all fillable field from model
        $creditType=(new CreditType)->getFillable();
        //request only fillable field from array pass from axios
        $creditType=$request->only($creditType);
        $creditType['language_id'] = config_language_id;
        $creditTypeValue=(new CreditTypeValue)->getFillable();
        $creditTypeValue=$request->only($creditTypeValue);
        $creditTypeValue=[
            'name'=>$request->type,
            'value'=>$request->value
        ];

        $condition=[
            'name'=>$creditType['name']
        ];

        $saveCreditType = (new DataAction)->StoreData(CreditType::class,$condition,'',$creditType,"credit_type_id");
        //if credit is inserted successfull
        if($saveCreditType['success']){
            
            //get id from child array(data)
            $creditTypeValue['credit_type_id'] = $saveCreditType['credit_type_id'];

            //return success message if data have been successfully save to database
            return (new DataAction)->StoreData(CreditTypeValue::class,[],"",$creditTypeValue); 

        }else{

            //if data doesn't saved to database this will return success false and message why data not save
            return $saveCreditType;

        }

    }

    public function edit($id)
    {
        return (new DataAction)->EditData(CreditType::class,$id);
        // $CreditType = CreditType::where($id)->first();
    }

    public function update(Request $request,$id)
    {
        
        $data=$request->all();

        return (new DataAction)->UpdateData(CreditType::class,$data,'credit_type_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(CreditType::class,'credit_type_id',$id);
        
    }
}
