<?php

namespace App\Http\Controllers\BackEnd\Attributes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Attribute\AttributeGroup;
use App\Http\Models\BackEnd\Attribute\AttributeGroupDescription;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class AttributeGroupController extends Controller
{
    public function index()
    {
        $AttributeGroup=AttributeGroup::AllAttributesGroup();
        return response()->json(['success'=>true,'data'=>$AttributeGroup,'total'=>count($AttributeGroup)]);
    }
    public function store(Request $request)
    {
        //data for AttributeGroup value
        $AttributeGroup=(new AttributeGroup)->getFillable();
        $AttributeGroup=$request->only($AttributeGroup);
        //Data for AttributeGroup description
        $attributeDesc=(new AttributeGroupDescription)->getFillable();
        $attributeDesc=$request->only($attributeDesc);
        $attributeDesc['language_id'] = config_language_id;
        //condition to check if AttributeGroup value is already existed
        $attrCond=[
            'name'=>$request->name
        ];
        
        //save AttributeGroup value and return attribute_id to insert to AttributeGroup description
        $saveAttribute = (new DataAction)->StoreData(AttributeGroup::class,[],"",$AttributeGroup,"attribute_group_id");

        //if AttributeGroup value is insert successfull
        if($saveAttribute['success']){
            
            //get id from child array(data)
            $attributeDesc['attribute_group_id'] = $saveAttribute['attribute_group_id'];

            //return success message if data have been successfully save to database
            return (new DataAction)->StoreData(AttributeGroupDescription::class,$attrCond,"",$attributeDesc); 

        }else{

            //if data doesn't saved to database this will return success false and message why data not save
            return $saveAttribute;

        }
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        $AttributeGroup=AttributeGroup::AttributeGroupEdit($id);
        foreach($AttributeGroup as $AttributeGroup){
        	$attributeArr=$AttributeGroup;
        }
        return response()->json(['success'=>true,'data'=>$attributeArr,'total'=>count($attributeArr)]);
    }
    public function update(Request $request,$id)
    {
        //data for AttributeGroup value
        $AttributeGroup=(new AttributeGroup)->getFillable();
        $AttributeGroup=$request->only($AttributeGroup);

        //Data for AttributeGroup description
        $attributeDesc=(new AttributeGroupDescription)->getFillable();
        $attributeDesc=$request->only($attributeDesc);

        $saveAttribute = (new DataAction)->UpdateData(AttributeGroup::class,$AttributeGroup,'attribute_group_id',$id);
    	return (new DataAction)->UpdateData(AttributeGroupDescription::class,$attributeDesc,'attribute_group_id',$id);
    } 
    public function destroy($id)
    {
        (new DataAction)->DeleteData(AttributeGroup::class,'attribute_group_id',$id);
        return (new DataAction)->DeleteData(AttributeGroupDescription::class,'attribute_group_id',$id);
    }
}
