<?php

namespace App\Http\Controllers\BackEnd\commons;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ValidateDataController extends Controller
{
    public function CheckDataExist($table,$field,$value)
    {
    	$existed=false;

        $count = DB::table($table)->where($field, $value)->count($field);

        if($count>0){
            $existed=true;
        }

        return response()->json([
            'Existed'=>$existed
        ]);
    }
}
