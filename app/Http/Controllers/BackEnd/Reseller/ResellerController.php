<?php

namespace App\Http\Controllers\BackEnd\Reseller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Reseller\Reseller;
use App\Http\Models\BackEnd\Language\Language;
use App\Http\Models\BackEnd\User\User;
use Illuminate\Support\Facades\DB;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class ResellerController extends Controller
{

    public function index()
    {
        $Resellers=Reseller::all();
        return response()->json(['success'=>true,'data'=>$Resellers,'total'=>count($Resellers)]);
    }

    public function show($id){
        return response()->json([]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $User = User::create([
            'user_group_id' => 5,
            'username' => $input['username'],
            'password' => bcrypt($input['password'])
        ]);
        $data=(new Reseller)->getFillable();
        $data=$request->only($data);
        $data['sec_user_id'] = $User->id;
        $condition=[
            'store_name'=>$data['store_name']
        ];

        return (new DataAction)->StoreData(Reseller::class,$condition,'',$data);

    }

    public function edit($id)
    {
        $Reseller = Reseller::where('reseller_id', $id)->first();
        $data['reseller'] = $Reseller;
        $user = User::select('username', 'password')->where('id', $Reseller->sec_user_id)->first();
        $data['user'] = $user?$user:'';
        return response()->json(['success'=>true, 'data'=>$data]);
        // return (new DataAction)->EditData(Reseller::class,$id);   
    }

    public function update(Request $request,$id)
    {
        $input = $request->all();
        $data=(new Reseller)->getFillable();
        $data=$request->only($data);
        $Reseller = Reseller::select('sec_user_id')->where('reseller_id', $id)->first();
        if($input['password'] != null){
            User::where('id', $Reseller->sec_user_id)
                ->update([
                    'username' => $input['username'],
                    'password' => bcrypt($input['password'])
                ]);
        }else{
            User::where('id', $Reseller->sec_user_id)
                ->update([
                    'username' => $input['username']
                ]);
        }
        return (new DataAction)->UpdateData(Reseller::class,$data,'reseller_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(Reseller::class,'reseller_id',$id);
        
    }

}
