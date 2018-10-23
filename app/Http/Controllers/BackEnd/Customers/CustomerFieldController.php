<?php

namespace App\Http\Controllers\BackEnd\Customers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\CustomerGroup\CustomerGroup;
use App\Http\Models\BackEnd\CustomerGroup\CustomerGroupDescription\CustomerGroupDescription;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class CustomerFieldController extends Controller
{
    public function index()
    {
        $CustomerGroup=CustomerGroup::AllCustomerGroups();
        return response()->json($CustomerGroup);
    }
    public function store(Request $request)
    {
        //data for Customer Group value
        $CustomerGroup=(new CustomerGroup)->getFillable();
        $CustomerGroup=$request->only($CustomerGroup);

        //Data for Customer Group description
        $customerGroupDesc=(new CustomerGroupDescription)->getFillable();
        $customerGroupDesc=$request->only($customerGroupDesc);
        
        //condition to check if Customer Group value is already existed
        $attrCond=[
            'name'=>$request->name
        ];
        
        //save Customer Group value and return customer_group_id to insert to Customer Group description
        $saveCustomerGroup = (new DataAction)->StoreData(CustomerGroup::class,[],"",$CustomerGroup,"customer_group_id");

        //if Customer Group value is insert successfull
        if($saveCustomerGroup['success']){
            
            //get id from child array(data)
            $customerGroupDesc['customer_group_id'] = $saveCustomerGroup['customer_group_id'];

            //return success message if data have been successfully save to database
            return (new DataAction)->StoreData(CustomerGroupDescription::class,$attrCond,"",$customerGroupDesc); 

        }else{

            //if data doesn't saved to database this will return success false and message why data not save
            return $saveCustomerGroup;

        }
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        $CustomerGroup=CustomerGroup::GroupEdit($id);
        foreach($CustomerGroup as $CustomerGroup){
        	$groupArr=$CustomerGroup;
        }
        return response()->json($groupArr);
    }
    public function update(Request $request,$id)
    {
        //data for Customer Group value
        $CustomerGroup=(new CustomerGroup)->getFillable();
        $CustomerGroup=$request->only($CustomerGroup);

        //Data for Customer Group description
        $customerGroupDesc=(new CustomerGroupDescription)->getFillable();
        $customerGroupDesc=$request->only($customerGroupDesc);

        $saveCustomerGroup = (new DataAction)->UpdateData(CustomerGroup::class,$CustomerGroup,'customer_group_id',$id);
    	return (new DataAction)->UpdateData(CustomerGroupDescription::class,$customerGroupDesc,'customer_group_id',$id);
    } 
    public function destroy($id)
    {
        (new DataAction)->DeleteData(CustomerGroup::class,'customer_group_id',$id);
        return (new DataAction)->DeleteData(CustomerGroupDescription::class,'customer_group_id',$id);
    }
}
