<?php

namespace App\Http\Models\BackEnd\Product;

use Illuminate\Database\Eloquent\Model;

class CategoryToStore extends Model
{
    protected $table = 'category_to_store';
    //
    protected $fillable=[
    	'category_id',
		'store_id',
		
    ];
    public $timestamps = false;
}
