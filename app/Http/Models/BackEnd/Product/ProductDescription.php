<?php

namespace App\Http\Models\BackEnd\Product;

use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    protected $table = 'product_description';
    protected $primaryKey='product_id';
    protected $fillable=[
    	'product_id',
		'name',
		'description',
		'language_id',
		'tag',
		'meta_title',
		'meta_description',
		'meta_keyword'
    ];
    public $timestamps = false;
}
