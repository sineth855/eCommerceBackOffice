<?php

namespace App\Http\Controllers\BackEnd\Attributes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Attribute\Attribute;
use App\Http\Models\BackEnd\Attribute\AttributeDescription;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class AttributesController extends Controller
{
    public function index()
    {
        $Attribute=Attribute::AllAttributes();
        return response()->json(['success'=>true,'data'=>$Attribute,'total'=>count($Attribute)]);
    }
    public function store(Request $request)
    {
        //data for Attribute value
        $Attribute=(new Attribute)->getFillable();
        $Attribute=$request->only($Attribute);
        //Data for Attribute description
        $attributeDesc=(new AttributeDescription)->getFillable();
        $attributeDesc=$request->only($attributeDesc);
        $attributeDesc['language_id'] = config_language_id;
        //condition to check if Attribute value is already existed
        $attrCond=[
            'name'=>$request->name
        ];
        
        //save Attribute value and return attribute_id to insert to Attribute description
        $saveAttribute = (new DataAction)->StoreData(Attribute::class,[],"",$Attribute,"attribute_id");

        //if Attribute value is insert successfull
        if($saveAttribute['success']){
            
            //get id from child array(data)
            $attributeDesc['attribute_id'] = $saveAttribute['attribute_id'];

            //return success message if data have been successfully save to database
            return (new DataAction)->StoreData(AttributeDescription::class,$attrCond,"",$attributeDesc); 

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
        $Attribute=Attribute::AttributeEdit($id);
        foreach($Attribute as $Attribute){
        	$attributeArr=$Attribute;
        }
        return response()->json(['success'=>true,'data'=>$attributeArr,'total'=>count($attributeArr)]);
    }
    public function update(Request $request,$id)
    {
        //data for Attribute value
        $Attribute=(new Attribute)->getFillable();
        $Attribute=$request->only($Attribute);

        //Data for Attribute description
        $attributeDesc=(new AttributeDescription)->getFillable();
        $attributeDesc=$request->only($attributeDesc);

        $saveAttribute = (new DataAction)->UpdateData(Attribute::class,$Attribute,'attribute_id',$id);
    	return (new DataAction)->UpdateData(AttributeDescription::class,$attributeDesc,'attribute_id',$id);
    } 
    public function destroy($id)
    {
        (new DataAction)->DeleteData(Attribute::class,'attribute_id',$id);
        return (new DataAction)->DeleteData(AttributeDescription::class,'attribute_id',$id);
    }
}
