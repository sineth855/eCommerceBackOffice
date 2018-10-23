<?php

namespace App\Http\Models\BackEnd\Manufacturer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Manufacturer extends Model
{
    protected $table='manufacturer';
    protected $primaryKey='manufacturer_id';
    protected $fillable=[
    	'name',
    	'sort_order',
    	'image'
    ];
    public $timestamps=false;
    static function AllManufacturers()
    {
        $Manufacturer=DB::table('manufacturer')
                  ->leftJoin('manufacturer_to_store','manufacturer.manufacturer_id','=','manufacturer_to_store.manufacturer_id')
                  ->leftJoin('store','manufacturer_to_store.store_id','=','store.store_id')
                  ->select('manufacturer.manufacturer_id','manufacturer.name','manufacturer.image','store.name as store')
                  ->get();
        return $Manufacturer;
    }
    static function ManufacturerEdit($id)
    {
        $Manufacturer=DB::table('manufacturer')
                  ->leftJoin('manufacturer_to_store','manufacturer.manufacturer_id','=','manufacturer_to_store.manufacturer_id')
                  ->leftJoin('store','manufacturer_to_store.store_id','=','store.store_id')
                  ->select('manufacturer.manufacturer_id','manufacturer.name','manufacturer.image','store.name as store')
                  ->where('manufacturer.manufacturer_id',$id)
                  ->get();
        return $Manufacturer;
    }
}
