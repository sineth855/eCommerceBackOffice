<?php

namespace App\Http\Models\BackEnd\Manufacturer;

use Illuminate\Database\Eloquent\Model;

class ManufacturerToStore extends Model
{
    protected $table='manufacturer_to_store';
    protected $primaryKey='manufacturer_id';
    protected $fillable=[
    	'manufacturer_id',
    	'store_id'
    ];
    public $timestamps=false;
}
