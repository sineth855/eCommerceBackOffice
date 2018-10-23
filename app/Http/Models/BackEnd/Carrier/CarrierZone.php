<?php

namespace App\Http\Models\BackEnd\Carrier;

use Illuminate\Database\Eloquent\Model;

class CarrierZone extends Model
{
    protected $table='carrier_zone';
    // protected $primaryKey='carrier_id';
    protected $fillable=[
    	'carrier_id',
        'zone_id',
    ];
    public $timestamps=false;
}
