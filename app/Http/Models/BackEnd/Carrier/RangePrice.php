<?php

namespace App\Http\Models\BackEnd\Carrier;

use Illuminate\Database\Eloquent\Model;

class RangePrice extends Model
{
    protected $table='range_price';
    protected $primaryKey='range_price_id';
    protected $fillable=[
    	'carrier_id',
    	'delimiter1',
        'delimiter2'
    ];
    public $timestamps=false;
}
