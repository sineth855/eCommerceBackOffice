<?php

namespace App\Http\Controllers\BackEnd\Taxs\TaxClass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Tax\TaxClass\TaxClass;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class TaxClassController extends Controller
{
    public function index()
    {

        $TaxClass=TaxClass::all();
        return response()->json(['success'=>true,'data'=>$TaxClass,'total'=>count($TaxClass)]);
    }

    public function show($id){
        return response()->json([]);
    }

    public function store(Request $request)
    {

        $data=(new TaxClass)->getFillable();
        $data=$request->only($data);
        $data['date_added'] = date("Y-m-d");
        $data['date_modified'] = date("Y-m-d");
        $condition=[
            'title'=>$data['title']
        ];

        return (new DataAction)->StoreData(TaxClass::class,$condition,'',$data);

    }

    public function edit($id)
    {
        return (new DataAction)->EditData(TaxClass::class,$id);
        
    }

    public function update(Request $request,$id)
    {
        
        $data=(new TaxClass)->getFillable();
        $data=$request->only($data);
        $data['date_modified'] = date("Y-m-d");
        return (new DataAction)->UpdateData(TaxClass::class,$data,'tax_class_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(TaxClass::class,'tax_class_id',$id);
        
    }
}
