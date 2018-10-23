<?php

namespace App\Http\Controllers\BackEnd\Lengths;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Length\Length;
use App\Http\Models\BackEnd\Length\LengthDescription;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class LengthsController extends Controller
{
    public function index()
    {
        $Length=Length::AllLengths();
        return response()->json(['success'=>true,'data'=>$Length,'total'=>count($Length)]);
    }
    public function store(Request $request)
    {
        //data for length value
        $length=(new Length)->getFillable();
        $length=$request->only($length);

        //Data for length description
        $lengthDesc=(new LengthDescription)->getFillable();
        $lengthDesc=$request->only($lengthDesc);
        $lengthDesc['language_id'] = config_language_id;
        //condition to check if length value is already existed
        $lenCond=[
            'value'=>$request->value
        ];
        
        //save length value and return length_class_id to insert to length description
        $saveLength = (new DataAction)->StoreData(Length::class,$lenCond,"",$length,"length_class_id");

        //if length value is insert successfull
        if($saveLength['success']){
            
            //get id from child array(data)
            $lengthDesc['length_class_id'] = $saveLength['length_class_id'];

            //return success message if data have been successfully save to database
            return (new DataAction)->StoreData(LengthDescription::class,[],"",$lengthDesc); 

        }else{

            //if data doesn't saved to database this will return success false and message why data not save
            return $saveLength;

        }
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        $Length=Length::LengthEdit($id);
        foreach($Length as $length){
        	$lengthArr=$length;
        }
        return response()->json(['success'=>true,'data'=>$lengthArr,'total'=>count($lengthArr)]);
    }
    public function update(Request $request,$id)
    {
        //data for length value
        $length=(new Length)->getFillable();
        $length=$request->only($length);

        //Data for length description
        $lengthDesc=(new LengthDescription)->getFillable();
        $lengthDesc=$request->only($lengthDesc);

        $length=[
        	'value'=>$length['value']
        ];
        $saveLength = (new DataAction)->UpdateData(Length::class,$length,'length_class_id',$id);
    	return (new DataAction)->UpdateData(LengthDescription::class,$lengthDesc,'length_class_id',$id);
    } 
    public function destroy($id)
    {
        (new DataAction)->DeleteData(Length::class,'length_class_id',$id);
        return (new DataAction)->DeleteData(LengthDescription::class,'length_class_id',$id);
    }
}
