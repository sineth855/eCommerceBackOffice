<?php

namespace App\Http\Controllers\FrontEnd\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\ChangeLocale;
use App\Http\Models\FrontEnd\Account\Customer;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{
    /**
     * Display Register Account Login
     *
     * @return \Illuminate\Http\Response
     */

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $token =  $user->createToken('Token Name')->accessToken;
            $customer = Customer::where('sec_user_id',$user->id)->first();
            return response()->json(['success' => true,'customer' => $customer,'token'=>$token], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function getPassword($email){
        $row = Customer::select('customer_id','password')
                            ->where('email',$email)
                            ->first();

        return $row;

    }   
    
    public function checkAccountAuthorize(){
        if(Auth::guard('account')->id()){
            return response()->json([
                'success'=>true,
                'message'=> "Logout successfully"
            ]);
        }else{
            return response()->json([
                'success'=>false,
                'message'=> "unauthorization"
            ]); 
        }
    }

    public function store(Request $request)
    {
        $success=false;
        $msg = '';
        $input = $request->all();             
        //$getPassword = md5($request->password);
        // $loginSave = $this->getMails($request->email);
        // $password = $this->getPasswordCustomer($getPassword);
        $chkHas = $this->chkCustomer($input['email'],bcrypt($input['password']));
        if($chkHas>0)
        {
            $success=true;
            $msg = "Data successfully Login";
        }else{
            $success=false;
            $msg = "Data not successfully Login!";
        }
        return response()->json([
            'success'=>$success,
            'message'=> $msg,
            'lang'=>Session::get('applangId')
        ]);
    }



    public function getMails($mail){
        $getMail = Customer::select('email')
                   ->where('email',$mail)
                   ->first();
        return $getMail;
    }
    public function getPasswordCustomer(){
        $hash = '$2y$10$FKZT7bMZh90Bx1L0FsKrmu/Q5/rOnnC0FRncmxahzba.Gfakzu8b6';
        $password=md5($hash);
        // dd($password);
        $getPassword = Customer::select(DB::raw('md5("password")'))
                   ->where(DB::raw('md5("password")'),md5($password))
                   ->first();
        return $getPassword;
    }

}
