<?php

namespace App\Http\Controllers\BackEnd\Filter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Filter\FilterGroup;
use App\Http\Models\BackEnd\Filter\FilterGroupDescription;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class FilterGroupController extends Controller
{
    public function index()
    {
        $FilterGroup=FilterGroup::AllFilterGroup();
        return response()->json(['success'=>true,'data'=>$FilterGroup,'total'=>count($FilterGroup)]);
    }
    public function store(Request $request)
    {
        //data for FilerGroup value
        $FilterGroup=(new FilterGroup)->getFillable();
        $FilterGroup=$request->only($FilterGroup);

        //Data for FilerGroup description
        $filterDesc=(new FilterGroupDescription)->getFillable();
        $filterDesc=$request->only($filterDesc);
        $filterDesc['language_id'] = config_language_id;
        //condition to check if FilerGroup value is already existed
        $filterCond=[
            'name'=>$request->name
        ];
        
        //save Filter Group value and return attribute_id to insert to Filter Group description
        $saveFiler = (new DataAction)->StoreData(FilterGroup::class,[],"",$FilterGroup,"filter_group_id");

        //if Filter Group value is insert successfull
        if($saveFiler['success']){
            
            //get id from child array(data)
            $filterDesc['filter_group_id'] = $saveFiler['filter_group_id'];

            //return success message if data have been successfully save to database
            return (new DataAction)->StoreData(FilterGroupDescription::class,$filterCond,"",$filterDesc); 

        }else{

            //if data doesn't saved to database this will return success false and message why data not save
            return $saveFiler;

        }
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        $FilterGroup=FilterGroup::FilterGroupEdit($id);
        foreach($FilterGroup as $value){
        	$filterGroup=$value;
        }
        return response()->json(['success'=>true,'data'=>$FilterGroup[0],'total'=>count($FilterGroup[0])]);
    }
    public function update(Request $request,$id)
    {
        //data for FilerGroup value
        $FilterGroup=(new FilterGroup)->getFillable();
        $FilterGroup=$request->only($FilterGroup);

        //Data for FilerGroup description
        $filterDesc=(new FilterGroupDescription)->getFillable();
        $filterDesc=$request->only($filterDesc);

        $saveFilter = (new DataAction)->UpdateData(FilterGroup::class,$FilterGroup,'filter_group_id',$id);
    	return (new DataAction)->UpdateData(FilterGroupDescription::class,$filterDesc,'filter_group_id',$id);
    } 
    public function destroy($id)
    {
        (new DataAction)->DeleteData(FilterGroup::class,'filter_group_id',$id);
        return (new DataAction)->DeleteData(FilterGroupDescription::class,'filter_group_id',$id);
    }
}
