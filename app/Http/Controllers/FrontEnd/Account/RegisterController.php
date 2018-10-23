<?php

namespace App\Http\Controllers\FrontEnd\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\FrontEnd\Account\Customer;
use DB;
use App\User;
use Carbon\Carbon;
use Validator;
use Session;

class RegisterController extends Controller
{
    /**
     * Display Register Account
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401); 
        }

        $input = $request->all();
        if($this->checkHasAccount($input['email'])==0){
            //$input['password'] = bcrypt($input['password']);
            // user account
            $User = User::create([
                'firstname'=>$input['first_name'],
                'lastname'=>$input['last_name'],
                'username'=>$input['email'],
                'email'=>$input['email'],
                'password'=>bcrypt(trim($input['password'])),
                'user_group_id'=>6,
            ]);
            // account customer
            $Customer = Customer::create([
                'sec_user_id'=>$User->id,
                'customer_group'=>1,
                'language_id'=>1,
                'firstname'=>$input['first_name'],
                'lastname'=>$input['last_name'],
                'email'=>$input['email'],
                'deviceId'=>$input['deviceId']
            ]);
            $token =  $User->createToken('Token Name')->accessToken;
            return response()->json(['success' => true,'token'=>$token,'user'=>$User,'message' => 'Register successfully.Please, Login.'], 200);
        }else{
            return response()->json(['success' => false, 'message' => 'This account is already registered!'], 200);
        }
    }

    public function checkHasAccount($email){
        $user = User::where('email',$email)->first();
        $result = 1;
        if($user){
            $result = 1;
        }else{
            $result = 0;
        }
        return $result;
    }

}
