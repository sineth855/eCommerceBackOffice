<?php

namespace App\Http\Controllers\BackEnd\Settings;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Setting\Setting;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class SettingsController extends Controller
{

    public function index()
    {

        $settings=Setting::AllSetting();

        return response()->json($settings);
    }

    public function show($id){
        return response()->json(Setting::find($id));
    }

    public function store(Request $request)
    {

        $data=$request['data'];
        $data["serialized"]=0;

        $condition=[
            'key'=>$data['key']
        ];

        return (new DataAction)->StoreData(Setting::class,$condition,'',$data);

    }

    public function edit($id)
    {
        return (new DataAction)->EditData(Setting::class,$id);
        
    }

    public function update(Request $request,$id)
    {
        
        $data=$request['data'];

        return (new DataAction)->UpdateData(Setting::class,$data,'setting_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(Setting::class,'setting_id',$id);
        
    }

    public function item()
    {

        $settingItems=Setting::FetchSettingItem();

        return response()->json($settingItems);

    }
    

}
