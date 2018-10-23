<?php

namespace App\Http\Controllers\BackEnd\Products\Attributes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Product\Attribute\Attribute;
use App\Http\Models\BackEnd\Language\Language;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class AttributeController extends Controller
{
    public function index()
    {

        $Attribute=Attribute::AllAttribute();

        return response()->json($Attribute);
    }

    public function show($id){
        return response()->json([]);
    }

    public function store(Request $request)
    {

        $data=$request['data'];

        $condition=[
            'name'=>$data['name']
        ];

        return (new DataAction)->StoreData(Attribute::class,$condition,'',$data);

    }

    public function edit($id)
    {
        return (new DataAction)->EditData(Attribute::class,$id);
        
    }

    public function update(Request $request,$id)
    {
        
        $data=$request['data'];

        return (new DataAction)->UpdateData(Attribute::class,$data,'attribute_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(Attribute::class,'attribute_id',$id);
        
    }
}
