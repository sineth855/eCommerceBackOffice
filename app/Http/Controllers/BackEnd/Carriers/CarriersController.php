<?php

namespace App\Http\Controllers\BackEnd\Carriers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\Carrier\Carrier;
use App\Http\Models\BackEnd\Carrier\CarrierStore;
use App\Http\Models\BackEnd\Carrier\CarrierZone;
use App\Http\Models\BackEnd\Carrier\RangePrice;
/*
    DataAction class use for any action the data from any table
    For more detail i have comment in DataAction class in commons folder
*/
use App\Http\Controllers\BackEnd\commons\DataAction;
use DB;

class CarriersController extends Controller
{
    public function index()
    {
        $Carriers=Carrier::where('deleted',false)->OrderBy('carrier_id','desc')->get();
        return response()->json(['success'=>true,'data'=>$Carriers,'total'=>count($Carriers)]);
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $data=(new Carrier)->getFillable();
        $data=$request->only($data);
        // dd($data);
        // dd($input['zone'][0]['id']);
        $input['image'] = 'image';
        $Carrier = Carrier::create([
            // 'reference_id' => $input['reference_id'],
            // 'tax_rules_group_id' => $input['tax_rules_group_id'],
            'name' => '2',
            'image' => $input['image'],
            'url' => $input['url'],
            'active' => $input['active'],
            // 'deleted' => $input['deleted'],
            // 'shipping_handling' => $input['shipping_handling'],
            // 'range_behavior' => $input['range_behavior'],
            // 'is_module' => $input['is_module'],
            'is_free' => $input['is_free'],
            // 'shipping_extenal' => $input['shipping_extenal'],
            // 'need_range' => $input['need_range'],
            // 'external_module_name' => $input['external_module_name'],
            // 'shipping_method' => $input['shipping_method'],
            // 'position' => $input['position'],
            'max_width' => $input['max_width'],
            'max_height' => $input['max_height'],
            'max_depth' => $input['max_depth'],
            'max_weight' => $input['max_weight'],
            'grade' => $input['grade'],
            'delay' => $input['delay']
        ]);
        for($i=0; $i <= count($input['zone']) - 1 ; $i ++){
            CarrierZone::create([
                'carrier_id' => $Carrier->carrier_id,
                'zone_id' => $input['zone'][$i]['zone_id']
            ]);
        }
        for($i=0; $i <= count($input['store']) - 1 ; $i ++){
            CarrierStore::create([
                'carrier_id' => $Carrier->carrier_id,
                'store_id' => $input['store'][$i]['store_id']
            ]);
        }
        $RangePrice = RangePrice::create([
            'carrier_id' => $Carrier->carrier_id,
            'delimiter1' => $input['delimiter1'],
            'delimiter2' => $input['delimiter2']
        ]);
        // $dir='/images/carrier';
        // $image=$request['image'];
        // $data['image']=$this->ImageMaker($dir,$image);
        // $id = (new DataAction)->StoreData(Carrier::class,[],"",$data,'id');
        // foreach ($request['store_id'] as $key => $value) {
        //     $data=['carrier_id'=>$id['id'],'store_id'=>$value];
        //     // return $data;
        //    $response=(new DataAction)->StoreData(CarrierShop::class,[],"",$data);
        // }
        return response()->json(['success'=>true,'data'=>$input,'message'=>'Data has been created.']);
    }
    public function show($id)
    {

    }
    public function edit($id)
    {
        $data=Carrier::find($id)->toArray();
        $data['zone'] = DB::table('carrier_zone')
                        ->Select('zone.zone_id','zone.name')
                        ->Join('zone','zone.zone_id','=','carrier_zone.zone_id')
                        ->where('carrier_zone.carrier_id',$id)
                        ->get();
        $data['store'] = DB::table('carrier_to_store')
                        ->Select('store.store_id','store.name')
                        ->Join('store','store.store_id','=','carrier_to_store.store_id')
                        ->where('carrier_to_store.carrier_id',$id)
                        ->get();
        // $data['range_price'] = RangePrice::where('carrier_id',$id)->get()->toArray();
        $data['range_price'] = RangePrice::where('carrier_id',$id)->first();
        return response()->json(['success'=>true,'data'=>$data]);
    }
    public function update(Request $request,$id)
    {
        $input = $request->all();
        $data=(new Carrier)->getFillable();
        $data=$request->only($data);
        $input['image'] = '';
        $dataRangePrice = [
            'carrier_id' => $id,
            'delimiter1' => $input['delimiter1']?$input['delimiter1']:0,
            'delimiter2' => $input['delimiter2']?$input['delimiter2']:0
        ];
        (new DataAction)->UpdateData(Carrier::class,$data,'carrier_id',$id);
        (new DataAction)->UpdateData(RangePrice::class,$dataRangePrice,'carrier_id',$id);
        CarrierZone::where('carrier_id',$id)->delete();
        // (new DataAction)->DeleteData(CarrierZone::class,'carrier_id',$id);
        for($i=0; $i <= count($input['zone']) - 1 ; $i ++){
            CarrierZone::create([
                'carrier_id' => $id,
                'zone_id' => $input['zone'][$i]['zone_id']
            ]);
        }
        CarrierStore::where('carrier_id',$id)->delete();
        // (new DataAction)->DeleteData(CarrierZone::class,'carrier_id',$id);
        for($i=0; $i <= count($input['store']) - 1 ; $i ++){
            CarrierStore::create([
                'carrier_id' => $id,
                'store_id' => $input['store'][$i]['store_id']
            ]);
        }
        // foreach ($request['store_id'] as $key => $value) {
        //     $data=['carrier_id'=>$id,'store_id'=>$value];
        //     $deleted=['deleted'=>true,'active'=>false];
        //    $response=(new DataAction)->StoreData(CarrierShop::class,[],"",$data);
        // }
        
        return response()->json(['success'=>true,'message'=>'Data has been updated.','data'=>$input]);
    }
    public function destroy($id)
    {
        Carrier::where('carrier_id',$id)->update(['deleted' => 1]);
        return response()->json(['success'=>true,'message'=>'Data has been deleted.']);
    }
}
