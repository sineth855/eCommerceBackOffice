<?php

namespace App\Http\Controllers\BackEnd\Downloads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Download\Download;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;

class DownloadsController extends Controller
{
   	public function index()
    {

        $Downloads=Download::AllDownloads();

        return response()->json($Downloads);
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

        return (new DataAction)->StoreData(Download::class,$condition,'',$data);

    }

    public function edit($id)
    {
        return (new DataAction)->EditData(Download::class,$id);
        
    }

    public function update(Request $request,$id)
    {
        
        $data=$request['data'];

        return (new DataAction)->UpdateData(Download::class,$data,'order_status_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(Download::class,'order_status_id',$id);
        
    }
}
