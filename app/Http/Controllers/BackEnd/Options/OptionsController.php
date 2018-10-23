<?php

namespace App\Http\Controllers\BackEnd\Options;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Option\Option;
use App\Http\Models\BackEnd\Option\OptionDescription;
use App\Http\Models\BackEnd\Option\OptionValue;
use App\Http\Models\BackEnd\Option\OptionValueDescription;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\BackEnd\commons\ImageMaker;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class OptionsController extends Controller
{
    public function index()
    {
        $Option=Option::AllOptions();
        return response()->json(['success'=>true,'data'=>$Option,'total'=>count($Option)]);
    }
    public function store(Request $request)
    {

        //data for OptionDesc value
        $OptionDesc=(new OptionDescription)->getFillable();
        $OptionDesc=$request->only($OptionDesc);

        
        //return $OptionValue;
        //condition to check if OptionValue value is already existed
        $optionCond=[
            'name'=>$OptionDesc['name'],
            'option_id'=>$OptionDesc['option_id'],
            'language_id'=>$OptionDesc['language_id']
        ];
        
        // //save OptionValue value and return option_id to insert to OptionValue description
        $saveOption = (new DataAction)->StoreData(OptionDescription::class,$optionCond,"and",$OptionDesc,"option_id");

        //if OptionValue value is insert successfull
        if($saveOption['success']){
            //get id from child array(data)
            //$OptionValue['option_id'] = $saveOption['option_id'];
            //return success message if data have been successfully save to database
            //Data for OptionValue description
            $OptionValue=array();
            $OptionValueDesc=array();
            foreach ($request['optionValues'] as $vk=>$vv){
                $OptionValue=array(
                    'option_id'=>$request->option_id,
                    'sort_order'=>$vv['sort_order'],
                    'image'=>(new ImageMaker)->base64ToImage('images\\icon',$vv['image'])
                );
                $OptionValueDesc=array(
                    'option_id'=>$request->option_id,
                    'language_id'=>$request->language_id,
                    'name'=>$vv['name']
                );
                $saveOptionValue = (new DataAction)->StoreData(OptionValue::class,[],"",$OptionValue,"option_value_id"); 
                if($saveOptionValue['success']){
                    $OptionValueDesc['option_value_id']=$saveOptionValue['option_value_id'];
                    $saveOptionValueDesc= (new DataAction)->StoreData(OptionValueDescription::class,[],"",$OptionValueDesc); 
                    //return $OptionValueDesc;
                }
            }
            return $saveOptionValueDesc;
            
        }else{
            //if data doesn't saved to database this will return success false and message why data not save
            return $saveOption;

        }
    }
    public function show($id)
    {

    }
    public function edit($id,$lid)
    {
        $OptionValue=Option::OptionEdit($id,$lid);
        foreach($OptionValue as $OptionValue){
        	$optionArr=$OptionValue;
        }
        return response()->json($optionArr);
    }
    public function update(Request $request,$id)
    {
        //data for OptionDesc value
        $OptionDesc=(new OptionDescription)->getFillable();
        $OptionDesc=$request->only($OptionDesc);
        $OptDescCon=[
            'option_id'=>$request['option_id'],
            'language_id'=>$request['language_id']
        ];
        //return $OptDescCon;
        $saveOption = (new DataAction)->UpdateDataMultiKey(OptionDescription::class,$OptionDesc,$OptDescCon,$id);
    	$OptionValue=array();
        $OptionValueDesc=array();
        $DeleteOptValue=Option::DeleteOptionValue($request->option_id,$request->language_id);
        if($DeleteOptValue>0){
            foreach ($request['optionValues'] as $vk=>$vv){
                $OptionValue=array(
                    'option_id'=>$request->option_id,
                    'sort_order'=>$vv['sort_order'],
                    'image'=>(new ImageMaker)->base64ToImage('images\\icon',$vv['image'])
                );
                $OptionValueDesc=array(
                    'option_id'=>$request->option_id,
                    'language_id'=>$request->language_id,
                    'name'=>$vv['name']
                );
                $saveOptionValue = (new DataAction)->StoreData(OptionValue::class,[],"",$OptionValue,"option_value_id"); 
                if($saveOptionValue['success']){
                    $OptionValueDesc['option_value_id']=$saveOptionValue['option_value_id'];
                    $saveOptionValueDesc= (new DataAction)->StoreData(OptionValueDescription::class,[],"",$OptionValueDesc); 
                    //return $OptionValueDesc;
                }
            }
            return $saveOptionValueDesc;
        }
        
    } 
    public function destroy($id)
    {
        (new DataAction)->DeleteData(OptionValue::class,'option_id',$id);
        return (new DataAction)->DeleteData(OptionValueDescription::class,'option_id',$id);
    }
}
