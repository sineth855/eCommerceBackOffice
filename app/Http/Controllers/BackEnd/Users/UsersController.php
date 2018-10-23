<?php

namespace App\Http\Controllers\BackEnd\Users;

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

class UsersController extends Controller
{
    public function index()
    {
        $Users = User::AllUser();
        return response()->json(['success'=>true,'data'=>$Users,'total'=>count($Users)]);
    }

    public function store(Request $request)
    {

        $data=(new User)->getFillable();
        $data=$request->only($data);
        
        $condition=[
            'username'=>$data['username'],
            'email'=>$data['email']
        ];
        return (new DataAction)->StoreData(User::class,$condition,"or",$data);

    }
    public function edit($id)
    {
        return (new DataAction)->EditData(User::class,$id);

    }
    
    public function update(Request $request,$id)
    {
        $data=(new User)->getFillable();
        $data=$request->only($data);
        if($request['newpassword'] != null){
            $data['password'] = bcrypt($request['password']);
        }

        if(@$data['image']){
            $data['image']=(new ImageMaker)->base64ToImage('images\\icon',$data['image']);    
        }
        return (new DataAction)->UpdateData(User::class,$data,'id',$id);
        // return response()->json($data);
    }
    public function destroy($id)
    {
        return (new DataAction)->DeleteData(User::class,'id',$id);
    }
    public function UserGroup()
    {
        return response()->json(UserGroup::all());
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
}
