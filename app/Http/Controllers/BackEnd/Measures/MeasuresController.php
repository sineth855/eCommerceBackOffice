<?php

namespace App\Http\Controllers\BackEnd\Measures;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Measure\Measure;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class MeasuresController extends Controller
{
    public function index()
    {
        $Currencies=Measure::all();
        return response()->json($Currencies);
    }
    public function store(Request $request)
    {
        $data=(new Measure)->getFillable();
        $data=$request->only($data);
        
        $condition=[
            'title'=>$data['title']
        ];

        return (new DataAction)->StoreData(Measure::class,$condition,"",$data);
        //return response()->json($data);
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        return (new DataAction)->EditData(Measure::class,$id);
    }
    public function update(Request $request,$id)
    {
        $data=(new Measure)->getFillable();
        $data=$request->only($data);
        return (new DataAction)->UpdateData(Measure::class,$data,'measure_id',$id);
    }
    public function destroy($id)
    {
        return (new DataAction)->DeleteData(Measure::class,'measure_id',$id);
    }
}
