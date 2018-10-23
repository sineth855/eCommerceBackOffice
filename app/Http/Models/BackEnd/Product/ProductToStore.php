<?php

namespace App\Http\Models\BackEnd\Product;

use Illuminate\Database\Eloquent\Model;

class ProductToStore extends Model
{
    protected $table = 'product_to_store';
    //
    protected $fillable=[
    	'product_id',
		'store_id',
		
    ];
    public $timestamps = false;
}
