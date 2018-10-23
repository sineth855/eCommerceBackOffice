<?php

namespace App\Http\Controllers\BackEnd\commons;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Country\Country;
use App\Http\Models\BackEnd\Zone\Zone;
use Illuminate\Support\Facades\DB;
use App\Http\Models\BackEnd\UserGroup\UserGroup;
class CommonsController extends Controller
{
    public function getLanguage()
    {

        $languages=DB::table('language')->select(['language_id as value','name as text'])->get();

        return response()->json($languages);

    }
    public function getCreditType()
    {

        $creditType=DB::table('credit_type')->select(['credit_type_id as value','name as text'])->get();

        return response()->json($creditType);

    }
    public function getGeoZone()
    {

        $GeoZone=DB::table('geo_zone')->select(['geo_zone_id as value','name as text'])->get();

        return response()->json($GeoZone);

    }
    public function getTaxRate()
    {

        $TaxRate=DB::table('tax_rate')->select(['tax_rate_id as value','name as text'])->get();

        return response()->json($TaxRate);

    }
    public function getTaxClass()
    {

        $TaxClass=DB::table('tax_class')->select(['tax_class_id as value','title as text'])->get();

        return response()->json($TaxClass);

    }
    public function getCustomerGroup()
    {

        $customerGroups=DB::table('customer_group_description')->select(['customer_group_id as value','name as text'])->get();

        return response()->json($customerGroups);

    }
    
    public function getStore()
    {

        $stores=DB::table('store')->select(['store_id as value','name as text'])->get();

        return response()->json($stores);

    }
    public function getAttributeGroup()
    {

        $atrributeGroup=DB::table('attribute_group_description')->select(['attribute_group_id as value','name as text'])->get();

        return response()->json($atrributeGroup);

    }
    public function getAttribute()
    {

        $atrribute=DB::table('attribute_description')->select(['attribute_id as value','name as text'])->get();

        return response()->json($atrribute);

    }
    public function getFilterGroup()
    {

        $filterGroup=DB::table('filter_group_description')->select(['filter_group_id as value','name as text'])->get();

        return response()->json($filterGroup);

    }
    public function getFilter()
    {

        $filterGroup=DB::table('filter_description')->select(['filter_id as value','name as text'])->get();

        return response()->json($filterGroup);

    }
    public function getLayout()
    {

        $filterGroup=DB::table('layout')->select(['layout_id as value','name as text'])->get();

        return response()->json($filterGroup);

    }
    public function getOptions()
    {

        $filterGroup=DB::table('option')->select(['option_id as value','type as text'])->get();

        return response()->json($filterGroup);

    }
    public function getStockStatus()
    {

        $filterGroup=DB::table('stock_status')->select(['stock_status_id as value','name as text'])->get();

        return response()->json($filterGroup);

    }
    public function getCarrier()
    {

        $filterGroup=DB::table('shipping_courier')->select(['shipping_courier_id as value','shipping_courier_name as text'])->get();

        return response()->json($filterGroup);

    }

    public function getUserGroups()
    {
        return response()->json(UserGroup::Groups());
    }

    public function getProductRelates()
    {

        $filterGroup=DB::table('product_description')->select(['product_id as value','name as text'])->get();

        return response()->json($filterGroup);

    }

    public function getCurrency($value='')
    {
        $filterGroup=DB::table('currency')->select(['currency_id as value','code as text'])->get();

        return response()->json($filterGroup);
    }
    public function getLocations($country_id='')
    {
        if ($country_id) {
            $data=Zone::select('country_id','name','zone_id as value')->where('country_id',$country_id)->where('status',1)->get()->toArray();
        }else{
            $data=Country::select('name','country_id as value')->where('status',1)->get()->toArray();
        }
        // dd($data);
        return $data;
    }
    public function getShipping($id='')
    {
        $data=ShippingCourier::select('shipping_courier_name as label','shipping_courier_code','shipping_courier_id as value');
        if (!$id) {
            $data=$data->get()->toArray();
        }else{
            $data=$data->where('shipping_courier_id',$id)->first()->toArray();
        }
        // dd($data);
        return $data;
    }
    public function getChildOption($optID)
    {

        $filterGroup=DB::table('option as o')
        ->Join('option_value_description as des','des.option_id','=','o.option_id')
        ->select(['des.option_value_id as value','des.name as text'])
        ->where('des.option_id',$optID)
        ->get();

        return response()->json($filterGroup);

    }
    public function getSelectList($cid)
    {
         $customerGroups=DB::table('customer_group_description')->select(['customer_group_id as value','name as text'])->get();
         $countries=DB::table('country')->select(['country_id as value','name as text'])->get();
         $zones=DB::table('zone')->select(['zone_id as value','name as text'])->where('country_id',$cid)->get();

        return response()->json(
            [
                'customerGroups'=>$customerGroups,
                'countryies'=>$countries,
                'zones'=>$zones
            ]
        );
    }
}
