<?php

namespace App\Http\Controllers\BackEnd\Country;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Country\Country;
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
class CountryController extends Controller
{
    public function index()
    {
        $Country = Country::all();
        return response()->json(['success'=>true,'data'=>$Country,'total'=>count($Country)]);
    }
    public function store(Request $request)
    {
        $data=(new Country)->getFillable();
        $data=$request->only($data);
        $condition=[
            'name'=>$data['name']
        ];
        return (new DataAction)->StoreData(Country::class,$condition,"",$data);
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        return (new DataAction)->EditData(Country::class,$id);
    }
    public function update(Request $request,$id)
    {
        $data=(new Country)->getFillable();
        $data=$request->only($data);
        return (new DataAction)->UpdateData(Country::class,$data,'country_id',$id);
    }
    public function destroy($id)
    {
    	return (new DataAction)->DeleteData(Country::class,'country_id',$id);
    }
     public function getCountry()
    {
        $data=Country::select('country_id')->get();
        // foreach ($data as $value) {
        //     $value->text=$value->Description()->value('name');
        //     $value->value=$value->country_id;
        // }
        return Country::select('country_id as value','name as text')->get();
        // dd($data->toArray());
        //return $data;
    }
}
