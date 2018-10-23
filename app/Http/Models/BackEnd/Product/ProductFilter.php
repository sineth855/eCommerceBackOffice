<?php

namespace App\Http\Models\BackEnd\product;

use Illuminate\Database\Eloquent\Model;

class ProductFilter extends Model
{
    protected $table = 'product_filter';
    
    protected $fillable=[
    	'product_id',
		'filter_id',
		
    ];
    public $timestamps = false;
}
