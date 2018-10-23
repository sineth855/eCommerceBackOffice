<?php

namespace App\Http\Controllers\BackEnd\Zone;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Zone\Zone;
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
class ZoneController extends Controller
{
    public function index()
    {
        $Zone = Zone::all();
        return response()->json(['success'=>true,'data'=>$Zone,'total'=>count($Zone)]);
    }
    public function store(Request $request)
    {
        $data=(new Zone)->getFillable();
        $data=$request->only($data);
        $condition=[
            'name'=>$data['name']
        ];
        return (new DataAction)->StoreData(Zone::class,$condition,"",$data);
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        return (new DataAction)->EditData(Zone::class,$id);
    }
    public function update(Request $request,$id)
    {
        $data=(new Zone)->getFillable();
        $data=$request->only($data);
        return (new DataAction)->UpdateData(Zone::class,$data,'geo_zone_id',$id);
    }
    public function destroy($id)
    {
    	return (new DataAction)->DeleteData(Zone::class,'geo_zone_id',$id);
    }
     public function getZone()
    {
        $data=Zone::select('geo_zone_id')->get();
        // foreach ($data as $value) {
        //     $value->text=$value->Description()->value('name');
        //     $value->value=$value->geo_zone_id;
        // }
        return Zone::select('geo_zone_id as value','name as text')->get();
        // dd($data->toArray());
        //return $data;
    }
}
