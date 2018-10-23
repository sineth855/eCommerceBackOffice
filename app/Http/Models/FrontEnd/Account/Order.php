<?php

namespace App\Http\Models\FrontEnd\Account;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'customer_wishlist';
	protected $fillable = [
						'product_id',
						'date_added'
					];
	public $timestamps = false;	

	// public function Product(){
	// 	return $this->belongsTo('App\Http\Models\FrontEnd\Product\Product','product_id');
	// }
}