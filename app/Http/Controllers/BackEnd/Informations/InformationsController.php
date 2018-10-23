<?php

namespace App\Http\Controllers\BackEnd\Informations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Information\Information;
use App\Http\Models\BackEnd\Information\InformationDescription;
use App\Http\Models\BackEnd\Information\InformationToStore;
use App\Http\Models\BackEnd\Information\InformationToLayout;
use App\Http\Models\BackEnd\SEOurl\SEOurl;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class InformationsController extends Controller
{
    public function index()
    {
        $Information=Information::AllInformations();
        return response()->json(['success'=>true,'data'=>$Information,'total'=>count($Information)]);
    }
    public function store(Request $request)
    {
        //data for Information value
        $Information=(new Information)->getFillable();
        $Information=$request->only($Information);

        //Data for Information description
        $informationDesc=(new InformationDescription)->getFillable();
        $informationDesc=$request->only($informationDesc);

        //Data for Information description
        $informationToStore=(new InformationToStore)->getFillable();
        $informationToStore=$request->only($informationToStore);

        //Data for Information description
        $informationToLayout=(new InformationToLayout)->getFillable();
        $informationToLayout=$request->only($informationToLayout);

        // $seoUrl=(new SEOurl)->getFillable();
        // $seoUrl=$request->only($seoUrl);
        
        //condition to check if Information value is already existed
        $informationDescCond=[
            'title'=>$request->title
        ];
        
        //save Information value and return information_id to insert to Information description
        $saveInformation = (new DataAction)->StoreData(Information::class,[],"",$Information,"information_id");

        //if Information value is insert successfull
        if($saveInformation['success']){
            
            //get id from child array(data)
            $informationDesc['information_id'] = $saveInformation['information_id'];
            $informationToStore['information_id'] = $saveInformation['information_id'];
            $informationToLayout['information_id'] = $saveInformation['information_id'];

            //return success message if data have been successfully save to database
            $saveDesc = (new DataAction)->StoreData(InformationDescription::class,$informationDescCond,"",$informationDesc); 
            if($saveDesc['success']){
            	(new DataAction)->StoreData(InformationToStore::class,[],"",$informationToStore); 
            	return (new DataAction)->StoreData(InformationToLayout::class,[],"",$informationToLayout); 
            	// $seoUrl['query']='null';
            	// return (new DataAction)->StoreData(SEOurl::class,[],"",$seoUrl); 
            }else{
            	return $saveDesc;
            }
        

        }else{

            //if data doesn't saved to database this will return success false and message why data not save
            return $saveDesc;

        }

        // return response()->json([
        // 	'information: '=>$Information,	
        // 	'desc: '=>$informationDesc,
        // 	'st: '=>$informationToStore,
        // 	'la: '=>$informationToLayout
        // ]);
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        $Information=Information::InformationEdit($id);
        foreach($Information as $Information){
        	$Information=$Information;
        }
        return response()->json(['success'=>true,'data'=>$Information,'total'=>count($Information)]);
    }
    public function update(Request $request,$id)
    {
        //data for Information value
        $Information=(new Information)->getFillable();
        $Information=$request->only($Information);

        //Data for Information description
        $informationDesc=(new InformationDescription)->getFillable();
        $informationDesc=$request->only($informationDesc);

        //Data for Information description
        $informationToStore=(new InformationToStore)->getFillable();
        $informationToStore=$request->only($informationToStore);

        //Data for Information description
        $informationToLayout=(new InformationToLayout)->getFillable();
        $informationToLayout=$request->only($informationToLayout);

        $saveInformation = (new DataAction)->UpdateData(Information::class,$Information,'information_id',$id);
    	 (new DataAction)->UpdateData(InformationDescription::class,$informationDesc,'information_id',$id);
    	 (new DataAction)->UpdateData(InformationToLayout::class,$informationToLayout,'information_id',$id);
    	return (new DataAction)->UpdateData(InformationToStore::class,$informationToStore,'information_id',$id);
    } 
    public function destroy($id)
    {
        (new DataAction)->DeleteData(Information::class,'information_id',$id);
        return (new DataAction)->DeleteData(InformationDescription::class,'information_id',$id);
    }
}
