<?php

namespace App\Http\Controllers\FrontEnd\Information;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class InformationController extends Controller
{
    /**
     * Display Information
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if (isset($id)) {
            $information_id = $id;
        } else {
            $information_id = 0;
        }
        $information_info = $this->getInformation($information_id);
        // dd($information_info);
        $data = array(
            'title'=>$information_info->title,
            'description'=>html_entity_decode($information_info->description, ENT_QUOTES, 'UTF-8'),
            'lang'=>Session::get('applangId')
        );
        
        // if ($information_info) {

        //     $informationInfor_arr = array();
        //     foreach ($information_info as $information_infos) {
        //         $informationInfor_arr[] = array(
        //             'title' => $information_infos->title,
        //             'description' => $information_infos->description
        //         );
        //     }

        //     return response()->json(['data' => $informationInfor_arr,'success' => true, 'message' => 'Success', 'lang'=>Session::get('applangId')]);
        // }
        return response()->json($data);
    }

    public function getInformation($information_id) {
        $query = DB::table('information')
                ->select('*')
                ->leftJoin('information_description','information.information_id','=','information_description.information_id')
                ->leftJoin('information_to_store','information.information_id','=','information_to_store.information_id')
                ->where('information.information_id',$information_id)
                ->where('information_description.language_id',1)
                ->where('information_to_store.store_id',config_store_id)
                ->where('information.status',1)
                ->distinct()
                ->first();

        return $query;
    }

}
