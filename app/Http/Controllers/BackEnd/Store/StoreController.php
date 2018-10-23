<?php

namespace App\Http\Controllers\BackEnd\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Store\Store;
use App\Http\Models\BackEnd\Language\Language;
use App\Http\Models\BackEnd\Setting\Setting;
use Illuminate\Support\Facades\DB;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
class StoreController extends Controller
{

    public function index()
    {
        $Store=Store::all();
        return response()->json(['success'=>true,'data'=>$Store,'total'=>count($Store)]);
    }

    public function show($id){
        return response()->json([]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        
        $data=(new Store)->getFillable();
        $data=$request->only($data);
        $condition=[
            'name'=>$data['name']
        ];

        $Store = Store::create($data);
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
          'config_store_id' => $Store->store_id,
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
                        'store_id' => $Store->store_id,
                        'code' => $code,
                        'key' => $key,
                        'value' => $value,
                        'serialized' => '1'
                    ]);

				} else {
                    Setting::where('code',$code)->where('key',$key)->insert([
                        'store_id' => $Store->store_id,
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
        $dataSettings = array();
        $data['store'] = Store::where('store_id', $id)->first();
        $SettingConfig = Setting::where('store_id', $id)->get();
        foreach ($SettingConfig as $key => $value) {
            $dataSettings[] = array(
                $value->key => $value->value
            );
        }
        $data['dataSettings'] = $dataSettings;
        return response()->json(['success'=>true,'data'=>$data ,'total'=>count($data)]);
        // return (new DataAction)->EditData(Store::class,$id);
    }

    public function update(Request $request,$id)
    {
        $input = $request->all();
        $data=(new Store)->getFillable();
        $data=$request->only($data);
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
            'config_store_id' => $id,
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
                      Setting::where('code',$code)->where('key',$key)->where('store_id', $id)->update([
                          'code' => $code,
                          'key' => $key,
                          'value' => $value,
                          'serialized' => '1'
                      ]);
  
                  } else {
                      Setting::where('code',$code)->where('key',$key)->where('store_id', $id)->update([
                          'code' => $code,
                          'key' => $key,
                          'value' => json_encode($value, true),
                          'serialized' => '1'
                      ]);
  
                  }
  
              }
          }

        return (new DataAction)->UpdateData(Store::class,$data,'store_id',$id);

    }

    public function destroy($id)
    {

        return (new DataAction)->DeleteData(Store::class,'store_id',$id);
        
    }

}
