<?php

namespace App\Http\Models\BackEnd\Carrier;

use Illuminate\Database\Eloquent\Model;

class CarrierStore extends Model
{
    protected $table='carrier_to_store';
    // protected $primaryKey='carrier_store_id';
    protected $fillable=[
    	'carrier_id',
    	'store_id',
    	
    ];
    public $timestamps=false;
}
