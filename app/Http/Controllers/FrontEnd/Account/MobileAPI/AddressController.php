<?php

namespace App\Http\Controllers\FrontEnd\Account\MobileAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\FrontEnd\Account\Address;
use Carbon\Carbon;
use DB;
use Auth;
use Session;

class AddressController extends Controller
{
    /**
     * Display a listing of the BestSeller Create On 01-02-2018
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){

    }
        
    public function index(){
      $sec_user_id = Auth::user()->id;
      $Address = Address::getAddress($sec_user_id);
      return response()->json(['data'=>$Address,'success' => true, 'message' => 'Success', 'lang'=>Session::get('applangId')]);
    }
}