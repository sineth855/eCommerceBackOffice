<?php

namespace App\Http\Models\BackEnd\Order;

use Illuminate\Database\Eloquent\Model;
use DB;

class OrderProduct extends Model
{
    protected $table = 'order_product';
	protected $primaryKey='order_product_id';
	protected $fillable =[
							'order_id',
							'product_id',
							'name',
							'model',
							'quantity',
							'price',
							'total',
							'tax',
							'reward',
						];
	public $timestamps = false;


	static function getProductBaseOrder($order_id, $store_id){
		$query = DB::table('order_product as op')
				  ->Join('order as o', 'o.order_id', '=', 'op.order_id')
				  ->Where('o.order_id', $order_id)
				  ->where('o.store_id', $store_id)
				  ->Select('op.*')
				  ->get();
	   
		return $query;
	}
}
