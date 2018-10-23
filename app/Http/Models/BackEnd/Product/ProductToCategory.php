<?php

namespace App\Http\Models\BackEnd\Product;

use Illuminate\Database\Eloquent\Model;
use DB;
class ProductToCategory extends Model
{
    protected $table = 'product_to_category';
    protected $fillable=[
    	'category_id',
		'product_id',
		
    ];
    public $timestamps = false;

}
