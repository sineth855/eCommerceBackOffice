<?php

namespace App\Http\Models\BackEnd\product;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    protected $table = 'product_discount';
    protected $primaryKey='product_discount_id';
    protected $fillable=[
		'product_id',
		'customer_group_id',
		'quantity',
		'priority',
		'price',
		'date_start',
		'date_end'
    ];
    public $timestamps = false;
}
