<?php

namespace App\Http\Controllers\BackEnd\Taxs\TaxRate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Tax\TaxRate\TaxRate;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class TaxRateController extends Controller
{
    
    public function index()
    {
        $TaxRate=TaxRate::AllTaxRate();
        return response()->json(['success'=>true,'data'=>$TaxRate,'total'=>count($TaxRate)]);
    }

    public function show($id){
        return response()->json([]);
    }

    public function store(Request $request)
    {

        $data=(new TaxRate)->getFillable();
        $data=$request->only($data);
        $data['date_added'] = date("Y-m-d");
        $data['date_modified'] = date("Y-m-d");
        $condition=[
            'name'=>$data['name']
        ];

        return (new DataAction)->StoreData(TaxRate::class,$condition,'',$data);

    }

    public function edit($id)
    {
        return (new DataAction)->EditData(TaxRate::class,$id);
        
    }

    public function update(Request $request,$id)
    {
        
        $data=(new TaxRate)->getFillable();
        $data=$request->only($data);
        $data['date_modified'] = date("Y-m-d");
        return (new DataAction)->UpdateData(TaxRate::class,$data,'tax_rate_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(TaxRate::class,'tax_rate_id',$id);
        
    }
}
