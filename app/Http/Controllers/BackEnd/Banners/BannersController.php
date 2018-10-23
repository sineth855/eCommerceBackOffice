<?php

namespace App\Http\Controllers\BackEnd\Banners;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Banner\Banner;
use App\Http\Models\BackEnd\Banner\BannerImage;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class BannersController extends Controller
{
    public function index()
    {
        $Banner=Banner::all();
        return response()->json($Banner);
    }
    public function store(Request $request)
    {
        //data for Banner value
        $Banner=(new Banner)->getFillable();
        $Banner=$request->only($Banner);

        //Data for Banner description
        $bannerImage=(new AttributeDescription)->getFillable();
        $bannerImage=$request->only($bannerImage);
        
        //condition to check if Banner value is already existed
        $attrCond=[
            'name'=>$request->name
        ];
        
        //save Banner value and return banner_id to insert to Banner description
        $saveAttribute = (new DataAction)->StoreData(Banner::class,[],"",$Banner,"banner_id");

        //if Banner value is insert successfull
        if($saveOption['success']){
            
            //get id from child array(data)
            $bannerImage['banner_id'] = $saveOption['banner_id'];

            //return success message if data have been successfully save to database
            return (new DataAction)->StoreData(BannerImage::class,$attrCond,"",$bannerImage); 

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
        $Banner=Banner::BannerEdit($id);
        foreach($Banner as $Banner){
        	$attributeArr=$Banner;
        }
        return response()->json($attributeArr);
    }
    public function update(Request $request,$id)
    {
        //data for Banner value
        $Banner=(new Banner)->getFillable();
        $Banner=$request->only($Banner);

        //Data for Banner description
        $bannerImage=(new Banner)->getFillable();
        $bannerImage=$request->only($bannerImage);

        $saveBanner = (new DataAction)->UpdateData(Banner::class,$Banner,'banner_id',$id);
        
        if(count($Banner)==1){
        	return $saveBanner;	
        }else{
        	return (new DataAction)->UpdateData(BannerImage::class,$bannerImage,'banner_id',$id);
        }
    } 
    public function updateStatus(Request $request,$id)
    {
    	$Banner=$request->status;
    	return (new DataAction)->UpdateData(Banner::class,$Banner,'banner_id',$id);
    }
    public function destroy($id)
    {
        (new DataAction)->DeleteData(Banner::class,'banner_id',$id);
        return (new DataAction)->DeleteData(BannerImage::class,'banner_id',$id);
    }
}
