<?php

namespace App\Http\Models\BackEnd\Product;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_image';
    
    protected $fillable=[
    	'product_image_id',
		'product_id',
		'image',
		'sort_order',
		
    ];
    public $timestamps = false;
}
