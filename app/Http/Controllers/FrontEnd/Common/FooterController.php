<?php

namespace App\Http\Controllers\FrontEnd\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class FooterController extends Controller
{
    /**
     * Display Footer
     *
     * @return \Illuminate\Http\Response
     */
    public function getFooter()
    {
        $informations = array();
        foreach ($this->getInformations() as $result) {
                if ($result->bottom) {
                    $informations[] = array(
                        'title' => $result->title,
                        // 'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
                        'href'  => 'information/information', 'information_id=' . $result->information_id,
                        'information_id' => $result->information_id
                    );
                }
        }

        return response()->json(['data' => $informations,'success' => true, 'message' => 'Success', 'lang'=>Session::get('applangId')]);
    }

    public function getInformations() {

        // Config Langauge 
        // config_language_id
        // config_store_id
        $query = DB::table('information')
                ->leftJoin('information_description','information.information_id','=','information_description.information_id')
                ->leftJoin('information_to_store','information.information_id','=','information_to_store.information_id')
                ->where('information_description.language_id',1)
                ->where('information_to_store.store_id',config_store_id)
                ->where('information.status',1)
                //->orderBy('information.sort_order','LCASE(information_description.title)','asc')
                ->orderBy('information.sort_order','asc')
                ->get();

        return $query;
    }

}
