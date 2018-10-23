<?php

namespace App\Http\Controllers\BackEnd\UserGroups;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Models\BackEnd\User\User;
use App\Http\Models\BackEnd\UserGroup\UserGroup;
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

class UserGroupsController extends Controller
{
    public function index()
    {

        $UserGroups = UserGroup::all();
        return response()->json(['success'=>true,'data'=>$UserGroups,'total'=>count($UserGroups)]);
    }

    public function store(Request $request)
    {
        $data=(new UserGroup)->getFillable();
        $data=$request->only($data);
        $condition=[
            'name'=>$data['name']
        ];
        return (new DataAction)->StoreData(UserGroup::class,$condition,"",$data);

    }
    public function edit($id)
    {
        return (new DataAction)->EditData(UserGroup::class,$id);
    }
    
    public function update(Request $request,$id)
    {
        $data=(new UserGroup)->getFillable();
        $data=$request->only($data);
        return (new DataAction)->UpdateData(UserGroup::class,$data,'user_group_id',$id);
    }
    public function destroy($id)
    {
        return (new DataAction)->DeleteData(UserGroup::class,'user_group_id',$id);
    }
    public function UserGroup()
    {
        return response()->json(UserGroup::Groups());
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
