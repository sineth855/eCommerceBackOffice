<?php

namespace App\Http\Controllers\FrontEnd\Design;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\FrontEnd\Design\Banner;
use App\Http\Models\FrontEnd\Design\BannerImage;
use DB;
use Session;

class BannerController extends Controller
{
    //
    public function index(){
    	// ***** Carosel Brand Parameter = 6 for getting brand data*****
    	$getBrands = $this->getDesign(6);
    	// ***** Carosel Sliders Parameter = 7 for getting slider data*****
    	$getSliders = $this->getDesign(7);
        $getProductCategory = $this->getDesign(8);
    	// ***** response results  *****
    	return response()->json(['brands' => $getBrands,'sliders'=>$getSliders,'getProductCategory'=>$getProductCategory,'success' => true, 'message' => 'Success', 'lang'=>Session::get('applangId')]);
    }

    // getDesign
    public function getDesign($banner_id){
    	$BannerArray = array();
    	$Banners = Banner::OrderBy('banner_id','DESC')
    	                 ->Where('banner_id',''.(int)$banner_id.'')
    	                 ->get();
    	foreach ($Banners as $Banner) {
    		$BannerImageArray = array();
    		$bannerId = $Banner->banner_id;
    		$BannerImages = BannerImage::Where('banner_id',''.(int)$bannerId.'')
    		                           ->Where('language_id',1)
    		                           ->get();
    		foreach ($BannerImages as $BannerImage) {
    			$BannerImageArray[] = array(
    				'title' => $BannerImage->title,
    				'image' => $BannerImage->image,
    				'link'  => $BannerImage->link,
    			);
    		}
    		$BannerArray[] = array(
    			'name' => $Banner->name,
    			'BannerImageArray' => $BannerImageArray,
    		);
		}
		return $BannerArray;
    }


}
