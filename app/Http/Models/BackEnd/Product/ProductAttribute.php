<?php

namespace App\Http\Models\BackEnd\product;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $table = 'product_attribute';
    
    protected $fillable=[
    	'product_id',
		'attribute_id',
		'language_id',
		'text',
		
    ];
    public $timestamps = false;
}
