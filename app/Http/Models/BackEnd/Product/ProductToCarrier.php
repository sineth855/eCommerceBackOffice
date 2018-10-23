<?php

namespace App\Http\Models\BackEnd\product;

use Illuminate\Database\Eloquent\Model;

class ProductToCarrier extends Model
{
    protected $table = 'product_to_carrier';
    
    protected $fillable=[
		'product_id',
		'carrier_id',
		'store_id'
    ];
    public $timestamps = false;
}
