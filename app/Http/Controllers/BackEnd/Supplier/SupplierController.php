<?php

namespace App\Http\Controllers\BackEnd\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Models\BackEnd\User\User;
use App\Http\Models\BackEnd\Supplier\Supplier;
use App\Http\Models\BackEnd\Supplier\SupplierToStore;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\BackEnd\commons\ImageMaker;
/*
    this controller use for create any validation function
    currently it have one function to validate data if exist or not yet exist
    then return the json to pass to axios.get() in veujs
    this function there are 3 parameter(tablename,fieldname,value)
        - tablename: table that we want to check
        - fieldname: field of that table we want to filter
        - value: value of field we want to check
*/
use App\Http\Controllers\BackEnd\commons\ValidateDataController;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
use App\Helpers\common;

class SupplierController extends Controller
{
    public function index()
    {

        $Suppliers = Supplier::all();
        return response()->json(['success'=>true,'data'=>$Suppliers,'total'=>count($Suppliers)]);
    }

    public function store(Request $request)
    {
        $data=(new Supplier)->getFillable();
        $data=$request->only($data);
        $data['date_added'] = date("Y-m-d H:i:s");
        $supplierId = Supplier::insertGetId($data);
        $condition=[
            
        ];
        if (isset($request['store']) && $request['store']) {
            # code...
            foreach ($request['store'] as $item) {
                $s2s['supplier_id'] = $supplierId;
                $s2s['store_id'] = $item['store_id'];
                SupplierToStore::insert($s2s);
            }
        }
        return response()->json(['success'=>true,'message'=>'Supplier has been created.','data'=>$data]);
    }
    public function edit($id)
    {
        $data = Supplier::find($id);
        $data['store'] = Supplier::getStoreBaseSupplierId($id);
        return response()->json(['success'=>true,'data'=>$data]);
    }
    
    public function update(Request $request,$id)
    {
        //data for Filter value
        $Supplier=(new Supplier)->getFillable();
        $Supplier=$request->only($Supplier);
        if (isset($request['store']) && $request['store']) {
            # code...
            SupplierToStore::where('supplier_id', $id)->delete();
            foreach ($request['store'] as $item) {
                $s2s['supplier_id'] = $id;
                $s2s['store_id'] = $item['store_id'];
                SupplierToStore::insert($s2s);
            }
        }
    	return (new DataAction)->UpdateData(Supplier::class,$Supplier,'supplier_id',$id);
    }
    public function destroy($id)
    {
        return (new DataAction)->DeleteData(Supplier::class,'supplier_id',$id);
    }
    public function Supplier()
    {
        return response()->json(Supplier::Groups());
    }
    public function ValidateData($field,$value){

        $existed=false;
        //instant the object
        $validate=new ValidateDataController;
        if($field=="username"){
            //return data json to vuejs when axios request
            return $validate->CheckDataExist('user','username',$value);    
        }elseif($field=="email"){
            //return data json to vuejs when axios request
            return $validate->CheckDataExist('user','email',$value);
        }
        
    }

    public function getPermission($id){
        $getPermission = common::getPermission($id);
        $data['success']=true;
        $data['data']=$getPermission;
        $data['total']=count($getPermission);
        return response()->json($data);
    }
}
