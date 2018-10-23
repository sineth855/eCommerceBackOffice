<?php

namespace App\Http\Controllers\BackEnd\Manufacturers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Manufacturer\Manufacturer;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
use App\Http\Controllers\BackEnd\commons\ImageMaker;
class ManufacturersController extends Controller
{
    public function index()
    {
        $Manufacturers=Manufacturer::all();
        return response()->json(['success'=>true,'data'=>$Manufacturers,'total'=>count($Manufacturers)]);
    }
    public function store(Request $request)
    {

    	$data=(new Manufacturer)->getFillable();
        $data=$request->only($data);
        $condition=[
            'name'=>$data['name']
        ];

        return (new DataAction)->StoreData(Manufacturer::class,$condition,"",$data);
        //return response()->json($data);
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        return (new DataAction)->EditData(Manufacturer::class,$id);
    }
    public function update(Request $request,$id)
    {
        $data=(new Manufacturer)->getFillable();
        $data=$request->only($data);
        return (new DataAction)->UpdateData(Manufacturer::class,$data,'manufacturer_id',$id);
    }
    public function destroy($id)
    {
    	$image = Manufacturer::find($id);
        // (new ImageMaker)->deleteFile($image->image);
        return (new DataAction)->DeleteData(Manufacturer::class,'manufacturer_id',$id);
        //return response()->json(['image'=>$file,'filename'=>$filename]);
    }
    public function getManufacturers()
    {
        return Manufacturer::select('name as text','manufacturer_id as value')->orderBy('sort_order')->get();
    }
}
