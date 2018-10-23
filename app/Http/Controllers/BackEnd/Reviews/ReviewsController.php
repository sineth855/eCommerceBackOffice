<?php

namespace App\Http\Controllers\BackEnd\Reviews;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Models\BackEnd\User\User;
use App\Http\Models\BackEnd\Review\Review;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\BackEnd\commons\ImageMaker;
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
use App\Helpers\common;

class ReviewsController extends Controller
{
    public function index()
    {
        $Reviews = Review::all();
        $data = array();
        foreach($Reviews as $row){
            $data[] = array(
                'review_id' => $row->review_id,
                'product_id' => $row->product_id,
                'product' => $row->ProductDescription->name,
                'author' => $row->author,
                'text' => $row->text,
                'rating' => $row->rating,
                'status' => $row->status,
                'date_added' => $row->date_added,
                'date_modified' => $row->date_modified
            );
        }
        return response()->json(['success'=>true,'data'=>$data,'total'=>count($Reviews)]);
    }

    public function store(Request $request)
    {
        $data=(new Review)->getFillable();
        $data=$request->only($data);
        $condition=[
            'author'=>$data['author']
        ];
        $data['date_added'] = date('Y-m-d H:i:s');
        $data['date_modified'] = date('Y-m-d H:i:s');
        return (new DataAction)->StoreData(Review::class,$condition,"",$data);

    }
    public function edit($id)
    {
        return (new DataAction)->EditData(Review::class,$id);
    }
    
    public function update(Request $request,$id)
    {
        //data for Filter value
        $Review=(new Review)->getFillable();
        $Review=$request->only($Review);

    	return (new DataAction)->UpdateData(Review::class,$Review,'review_id',$id);
    }
    public function destroy($id)
    {
        return (new DataAction)->DeleteData(Review::class,'review_id',$id);
    }
    public function Supplier()
    {
        return response()->json(Review::Groups());
    }
    public function ValidateData($field,$value){

        $existed=false;
        //instant the object
        $validate=new ValidateDataController;
        if($field=="username"){
            //return data json to vuejs when axios request
            return $validate->CheckDataExist('user','username',$value);    
        }elseif($field=="email"){
            //return data json to vuejs when axios request
            return $validate->CheckDataExist('user','email',$value);
        }
        
    }

    public function getPermission($id){
        $getPermission = common::getPermission($id);
        $data['success']=true;
        $data['data']=$getPermission;
        $data['total']=count($getPermission);
        return response()->json($data);
    }
}
