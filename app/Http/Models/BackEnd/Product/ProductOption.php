<?php

namespace App\Http\Models\BackEnd\product;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $table = 'product_option';
    protected $primaryKey='product_option_id';
    
    protected $fillable=[
    	
		'product_id',
		'option_id',
		'value',
		'required',
		
    ];
    public $timestamps = false;
}
