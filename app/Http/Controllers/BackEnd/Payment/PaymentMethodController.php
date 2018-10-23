<?php

namespace App\Http\Controllers\BackEnd\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Payment\PaymentMethod;
use App\Http\Models\BackEnd\Payment\PaymentConfiguration;
use App\Http\Models\BackEnd\Language\Language;
use App\Http\Models\BackEnd\Setting\Setting;
use Illuminate\Support\Facades\DB;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class PaymentMethodController extends Controller
{

    public function index()
    {
        $PaymentMethod=PaymentMethod::all();
        return response()->json(['success'=>true,'data'=>$PaymentMethod,'total'=>count($PaymentMethod)]);
    }

    public function show($id){
        return response()->json([]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        
        $data=(new PaymentMethod)->getFillable();
        $data=$request->only($data);
        $condition=[
            'name'=>$data['name']
        ];

        $PaymentMethod = PaymentMethod::create($data);
        $dataSettings = [
          'config_account_id' => $input['config_account_id'],
          'config_address' => $input['config_address'],
          'config_cart_weight' => $input['config_cart_weight'],
          'config_checkout_guest' => $input['config_checkout_guest'],
          'config_checkout_id' => $input['config_checkout_id'],
          'config_comment' => $input['config_comment'],
          'config_country_id' => $input['config_country_id'],
          'config_currency' => $input['config_currency'],
          'config_customer_group_id' => $input['config_customer_group_id'],
          'config_customer_price' => $input['config_customer_price'],
          'config_email' => $input['config_email'],
          'config_fax' => $input['config_fax'],
          'config_geocode' => $input['config_geocode'],
          'config_icon' => $input['config_icon'],
          'config_image' => $input['config_image'],
          'config_language_id' => $input['config_language_id'],
          'config_language' => $input['config_language'],
          'config_layout_id' => $input['config_layout_id'],
          'config_logo' => $input['config_logo'],
          'config_meta_description' => $input['config_meta_description'],
          'config_meta_keyword' => $input['config_meta_keyword'],
          'config_meta_title' => $input['config_meta_title'],
          'config_name' => $input['config_name'],
          'config_open' => $input['config_open'],
          'config_order_status_id' => $input['config_order_status_id'],
          'config_owner' => $input['config_owner'],
          'config_review_status' => $input['config_review_status'],
          'config_secure' => $input['config_secure'],
          'config_ssl' => $input['config_ssl'],
          'config_stock_checkout' => $input['config_stock_checkout'],
          'config_stock_display' => $input['config_stock_display'],
          'config_store_id' => $PaymentMethod->store_id,
          'config_tax' => $input['config_tax'],
          'config_tax_customer' => $input['config_tax_customer'],
          'config_tax_default' => $input['config_tax_default'],
          'config_theme' => $input['config_theme'],
          'config_url' => $input['config_url'],
          'config_zone_id' => $input['config_zone_id']
        ];

        
        $code = "config";
		foreach ($dataSettings as $key => $value) {
            // $key['config_image'] = "here is image";
			if (substr($key, 0, strlen($code)) == $code) {

				if (!is_array($value)) {
                    Setting::where('code',$code)->where('key',$key)->insert([
                        'store_id' => $PaymentMethod->store_id,
                        'code' => $code,
                        'key' => $key,
                        'value' => $value,
                        'serialized' => '1'
                    ]);

				} else {
                    Setting::where('code',$code)->where('key',$key)->insert([
                        'store_id' => $PaymentMethod->store_id,
                        'code' => $code,
                        'key' => $key,
                        'value' => json_encode($value, true),
                        'serialized' => '1'
                    ]);

				}

			}
		}
        return response()->json(['success'=>true,'message'=>'Data has been created.']);
    }

    public function edit($id)
    {
        $PaymentConfiguration = array();
        $data['payment'] = PaymentMethod::where('payment_method_id', $id)->first();
        $PaymentConfig = PaymentConfiguration::where('payment_method_id', $id)->get();
        foreach ($PaymentConfig as $key => $value) {
            $PaymentConfiguration[] = array(
                $value->key => $value->value
            );
        }
        $data['PaymentConfiguration'] = $PaymentConfiguration;
        return response()->json(['success'=>true,'data'=>$data ,'total'=>count($data)]);
    }

    public function update(Request $request,$id)
    {
        $input = $request->all();
        $data=(new PaymentConfiguration)->getFillable();
        $data=$request->only($data);
        $dataSettings = [
            'config_account_owner' => $input['config_account_owner'],
            'config_account_detail' => $input['config_account_detail'],
            'config_bank_address' => $input['config_bank_address'],
            'config_payee' => $input['config_payee'],
            'config_payee_address' => $input['config_payee_address']
          ];
  
          
          $code = "config";
          foreach ($dataSettings as $key => $value) {
              // $key['config_image'] = "here is image";
              if (substr($key, 0, strlen($code)) == $code) {
  
                  if (!is_array($value)) {
                      PaymentConfiguration::where('code',$code)->where('key',$key)->where('payment_method_id', $id)->update([
                          'code' => $code,
                          'key' => $key,
                          'value' => $value,
                          'serialized' => '1'
                      ]);
  
                  } else {
                      PaymentConfiguration::where('code',$code)->where('key',$key)->where('payment_method_id', $id)->update([
                          'code' => $code,
                          'key' => $key,
                          'value' => json_encode($value, true),
                          'serialized' => '1'
                      ]);
  
                  }
  
              }
          }

        // return (new DataAction)->UpdateData(PaymentMethod::class,$data,'store_id',$id);
        return response()->json(['success'=>true,'message'=>'Data updated successfully.']);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(PaymentMethod::class,'store_id',$id);
        
    }

}
