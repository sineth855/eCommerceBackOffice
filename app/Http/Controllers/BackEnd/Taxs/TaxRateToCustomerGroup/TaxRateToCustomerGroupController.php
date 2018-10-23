<?php

namespace App\Http\Controllers\BackEnd\Taxs\TaxRateToCustomerGroup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Tax\TaxRateToCustomerGroup\TaxRateToCustomerGroup;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class TaxRateToCustomerGroupController extends Controller
{
    public function index()
    {

        $TaxRateToCustomerGroup=TaxRateToCustomerGroup::AllTaxRateToCustomerGroup();

        return response()->json($TaxRateToCustomerGroup);
    }

    public function show($id){
        return response()->json([]);
    }

    public function store(Request $request)
    {

        $data=(new TaxRateToCustomerGroup)->getFillable();
        $data=$request->only($data);

        $condition=[
        	'tax_rate_id'=>$data['tax_rate_id'],
        	'customer_group_id'=>$data['customer_group_id']
        ];

        return (new DataAction)->StoreData(TaxRateToCustomerGroup::class,$condition,'and',$data);

    }

    public function edit($id)
    {
        return (new DataAction)->EditData(TaxRateToCustomerGroup::class,$id);
        
    }

    public function update(Request $request,$id)
    {
        
        $data=(new TaxRateToCustomerGroup)->getFillable();
        $data=$request->only($data);

        return (new DataAction)->UpdateData(TaxRateToCustomerGroup::class,$data,'tax_rate_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(TaxRateToCustomerGroup::class,'tax_rate_id',$id);
        
    }
}
