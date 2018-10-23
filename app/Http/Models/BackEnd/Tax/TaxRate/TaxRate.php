<?php

namespace App\Http\Models\BackEnd\Tax\TaxRate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class TaxRate extends Model
{
	protected $table='tax_rate';
    protected $primaryKey='tax_rate_id';
    protected $fillable=[
    	'geo_zone_id',
    	'name',
    	'rate',
    	'type',
    	'date_added',
    	'date_modified'
    ];
    public $timestamps=false;
    static function AllTaxRate()
    {
        $taxRate=DB::table('tax_rate')
                  ->leftJoin('geo_zone','tax_rate.geo_zone_id','=','geo_zone.geo_zone_id')
                  ->select('tax_rate_id','tax_rate.name','geo_zone.name as geo_zone','rate','type','tax_rate.date_added','tax_rate.date_modified')
                  ->get();
        return $taxRate;
    }
}
