<?php

namespace App\Http\Controllers\BackEnd\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Models\BackEnd\User\User;
use App\Http\Models\BackEnd\User\Config;
use App\Http\Models\BackEnd\Store\Store;
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

class ResellerController extends Controller
{
    public function index()
    {
        $Users = User::getUserReseller($user_group_reseller=5);
        return response()->json($Users);
    }

    public function store(Request $request)
    {

        $data=(new User)->getFillable();
        $user=$request['user'];
        $user['image']=(new ImageMaker)->base64ToImage('images\\icon',$user['image']);
        $config=$request['config'];
        $configArr=array();
        $config['config_image']=(new ImageMaker)->base64ToImage('images\\store',$user['image']);
        $storeInfo=$request['storeInfo'];
        // $condition=[
        //     'username'=>$data['username'],
        //     'email'=>$data['email']
        // ];
        // $data['image']=(new ImageMaker)->base64ToImage('images\\icon',$data['image']);
        $saveReseller = (new DataAction)->StoreData(User::class,[],"",$user,"user_id");
        if($saveReseller['success']){
            $storeInfo['owner_id']=$saveReseller['user_id'];
            $saveStore = (new DataAction)->StoreData(Store::class,[],"",$storeInfo,"store_id");
            if($saveStore['success']){
                $config['config_store_id']=$saveStore['store_id'];
                foreach ($config as $key=>$value){
                    $configArr=['store_id'=>$saveStore['store_id'],'code'=>'config','key'=>$key,'value'=>$value];
                    $saveConfig=(new DataAction)->StoreData(Config::class,[],"",$configArr);
                }
                return $saveConfig;
            }
            return $saveStore;
        }
        else{
            return $saveReseller;
        }
    }
    public function show($id)
    {

    }

    public function edit($id)
    {
        $reseller=(new DataAction)->EditData(User::class,$id);
        // return response()->json([
        //     'resellerInfo'=> $reseller,
        //     'config'=>Config::getConfigToUpdate($id)
        // ]);
        $config = Config::getConfigToUpdate($id);
        $configItem=array();
        foreach($config as $key=>$value){
            if(is_numeric($value->value)){
                $val=(int)$value->value;
            }else{
                $val=$value->value;
            }
            $configItem[$value->key]=$val;
        }
        foreach($reseller as $key=>$res){
            if(is_numeric($res)){
                $reseller[]=(int)$res;
            }
        }
        return response()->json([
            'resellerInfo'=> $reseller,
            'configItem'=>$configItem
        ]);

    }
    
    public function update(Request $request,$id)
    {
        $data=(new User)->getFillable();
        $user=$request['user'];
        $user['image']=(new ImageMaker)->base64ToImage('images\\icon',$user['image']);
        $config=$request['config'];
        $configArr=array();
        $config['config_image']=(new ImageMaker)->base64ToImage('images\\store',$user['image']);
        $storeInfo=$request['storeInfo'];
        // $condition=[
        //     'username'=>$data['username'],
        //     'email'=>$data['email']
        // ];
        // $data['image']=(new ImageMaker)->base64ToImage('images\\icon',$data['image']);
        $saveReseller = (new DataAction)->UpdateData(User::class,$user,"id",$id);
        
        $saveStore = (new DataAction)->UpdateData(Store::class,$storeInfo,"owner_id",$id);
        $store=Store::where('owner_id',$id)->first();
        //return $store->store_id;
        //$config['config_store_id']=$saveStore['store_id'];
        foreach ($config as $key=>$value){
            //$configArr[]=['code'=>'config','key'=>$key,'value'=>$value];
            Config::where(['store_id'=>$store->store_id,'key'=>$key])->update(['code'=>'config','key'=>$key,'value'=>$value]);
        }
        return array(
            'success'=>true,
            'message'=>'Data successfully updated.'

        );
        //return $saveConfig;
    }
    public function destroy($id)
    {
        return (new DataAction)->DeleteData(User::class,'id',$id);
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
}
