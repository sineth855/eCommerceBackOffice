<?php

namespace App\Http\Controllers\BackEnd\Customers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Customer\Customer;
use App\Http\Models\BackEnd\Customer\CustomerAddress;
use App\Http\Models\BackEnd\Customer\CustomerIp;
use App\Http\Models\BackEnd\User\User;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class CustomersController extends Controller
{
    public function index()
    {
        $Customer=Customer::CustomerList();
        return response()->json(['success'=>true,'data'=>$Customer,'total'=>count($Customer)]);
    }
    public function store(Request $request)
    {
        $User = User::create([
            'user_group_id' => 5,
            'username' => $request['username'],
            'password' => bcrypt($request['password'])
        ]);
        //data for Customer Group value
        $Customer=(new Customer)->getFillable();
        // $Customer=array_only($request['general'],$fill);
        $Customer=$request->only($Customer);
        $Customer['date_added']=date('Y-m-d H:i:s'); 
        $Customer['ip']='1'; 
        $Customer['sec_user_id'] = $User->id;
        //save Customer Group value and return customer_id to insert to Customer Group description
       $saveCustomer = (new DataAction)->StoreData(Customer::class,[],"",$Customer,"customer_id");
        //if Customer Group value is insert successfull
        if($saveCustomer['success']){
            $customerIp=['customer_id'=>$saveCustomer['customer_id'],'ip'=>$request->ip(),'date_added'=>date('Y-m-d H:i:s')];
            (new DataAction)->StoreData(CustomerIp::class,[],"",$customerIp);
            //Data for Customer Address
            if(!empty($request['address'])){
                $Address=array();
                foreach($request['address'] as $key=>$form){
                    $Address=$form;
                    $Address['customer_id'] = $saveCustomer['customer_id'];
                    //return success message if data have been successfully save to database
                    $saveAddress=(new DataAction)->StoreData(CustomerAddress::class,[],"",$Address); 
                }
                return $saveAddress;
            }else{
                return $saveCustomer;
            }
        }else{
            //if data doesn't saved to database this will return success false and message why data not save
            return $saveCustomer;
        }
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        $data = Customer::find($id);
        $data['customer_address'] = CustomerAddress::where('customer_id', $id)->get();
        return response()->json(['success'=>true,'data'=>$data]);
        
    }
    public function update(Request $request,$id)
    {
        //data for Customer Group value
        $Customer=(new Customer)->getFillable();
        $Customer=$request->only($Customer);
        $Customer['ip']='1';
        $input = $request->all();
        $CustomerInfo = Customer::select('sec_user_id')->where('customer_id', $id)->first();
        if($input['password'] != null){
            User::where('id', $CustomerInfo->sec_user_id)
                ->update([
                    'username' => $input['username'],
                    'password' => bcrypt($input['password'])
                ]);
        }else{
            User::where('id', $CustomerInfo->sec_user_id)
                ->update([
                    'username' => $input['username']
                ]);
        }
        
        //save Customer Group value and return customer_id to insert to Customer Group description
       $saveCustomer = (new DataAction)->UpdateData(Customer::class,$Customer,"customer_id",$id);

       CustomerAddress::where('customer_id',$id)->delete();
        if (isset($request['address']) && $request['address']) {
            # code...
            foreach ($request['address'] as $item) {
                $ca['customer_id'] = $id;
                $ca['firstname'] = $item['firstname'];
                $ca['lastname'] = $item['lastname'];
                $ca['company'] = $item['company'];
                $ca['address_1'] = $item['address_1'];
                $ca['address_2'] = $item['address_2'];
                $ca['city'] = $item['city'];
                $ca['postcode'] = $item['postcode'];
                $ca['country'] = $item['country'];
                $ca['zone'] = $item['zone'];
                $ca['custom_field'] = 'Normal Customer';
                CustomerAddress::insert($ca);
            }
        }

       return $saveCustomer;
        // //if Customer Group value is insert successfull
        // if($saveCustomer['success']){
        //     $customerIp=['ip'=>$request->ip(),'date_added'=>date('Y-m-d H:i:s')];
        //     (new DataAction)->UpdateData(CustomerIp::class,$customerIp,"customer_id",$id);
        //     //delete all address before and re insert to update address
        //     $deleteAddress=Customer::DeleteAddress($id);
        //     if($deleteAddress>0){
        //         //Data for Customer Address
        //         if(!empty($request['addressItem'])){
        //             $Address=array();
        //             foreach($request['addressItem'] as $key=>$form){
        //                 $Address=$form;
        //                 $Address['customer_id'] = $id;
        //                 //return success message if data have been successfully save to database
        //                 $saveAddress=(new DataAction)->StoreData(CustomerAddress::class,[],"",$Address); 
        //             }
        //             return $saveAddress;
        //         }else{
        //             return $saveCustomer;
        //         }
        //     }
        // }else{
        //     //if data doesn't saved to database this will return success false and message why data not save
        //     return $saveCustomer;
        // }
    } 
    public function destroy($id)
    {
        return (new DataAction)->DeleteData(Customer::class,'customer_id',$id);
    }
    public function filterCustomer(Request $request)
    {
        $result = Customer::customerByFilter($request->all());
        return response()->json(['result'=>true,'data'=>$result]);
    }
}
