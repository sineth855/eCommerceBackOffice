<?php

namespace App\Http\Controllers\BackEnd\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\UserRole\UserRole;
use App\Http\Models\FrontEnd\SessionModel;
use App\Helpers\common;
// use Helpers;

class GroupRolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }
    
    public function index()
    {
        $UserRoles = UserRole::where('is_active',1)->get();
        $i = 1;
        $data_info = array();
        foreach($UserRoles as $ur){
            $data_info[] = array(
                'id'=>$i,
                'role_id'=>$ur->id,
                'name'=>$ur->name,
                'user_group'=>$ur->UserGroup->name,
                'remark'=>$ur->remark
            );
        }
        $data['success'] = true;
        $data['message'] = 'Success get alll data.';
        $data['data'] = $data_info;
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $data['success'] = true;
        $data['message'] = 'Save data successfully.';
        $data['data'] = $input;
        UserRole::create($input);
        return response()->json($data);
    }
    public function edit($id)
    {
        $data['success'] = true;
        $data['message'] = 'Successfully.';
        $data['data'] = UserRole::find($id);
        return response()->json($data);
        // return (new DataAction)->EditData(User::class,$id);
    }
    
    public function update(Request $request,$id)
    {
        $input = $request->all();
        $data['success'] = true;
        $data['message'] = 'Update Successfully.';
        $data['data'] = UserRole::where('id',$id)->update($input);
        return response()->json($data);
    }
    public function destroy($id)
    {
        $data['success'] = true;
        $data['message'] = 'Delete Successfully.';
        $data['data'] = UserRole::where('id',$id)->update(['is_active',0]);
        return response()->json($data);
    }

    public function getMenus()
    {
        $getMenus = common::getMenus(2,1);
        $data = array('data'=>$getMenus);
        return response()->json($data);
        // return $getMenus
    }
    
}
