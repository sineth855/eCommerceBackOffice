<?php

namespace App\Http\Controllers\BackEnd\Taxs\TaxRule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Tax\TaxRule\TaxRule;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class TaxRuleController extends Controller
{
    public function index()
    {
        $TaxRule=TaxRule::AllTaxRule();
        return response()->json(['success'=>true,'data'=>$TaxRule,'total'=>count($TaxRule)]);
    }

    public function show($id){
        return response()->json([]);
    }

    public function store(Request $request)
    {

        $data=(new TaxRule)->getFillable();
        $data=$request->only($data);

        $condition=[
        	'tax_class_id'=>$data['tax_class_id'],
        	'tax_rate_id'=>$data['tax_rate_id'],
        	'based'=>$data['based']
        ];

        return (new DataAction)->StoreData(TaxRule::class,$condition,'and',$data);

    }

    public function edit($id)
    {
        return (new DataAction)->EditData(TaxRule::class,$id);
        
    }

    public function update(Request $request,$id)
    {
        
        $data=(new TaxRule)->getFillable();
        $data=$request->only($data);

        return (new DataAction)->UpdateData(TaxRule::class,$data,'tax_rule_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(TaxRule::class,'tax_rule_id',$id);
        
    }
}
