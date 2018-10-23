<?php

namespace App\http\models\frontend\Order;

use Illuminate\Database\Eloquent\Model;

class OrderOption extends Model
{
    protected $table = 'order_option';
	protected $primaryKey='order_option_id';
	protected $fillable =[
							'order_id',
							'order_product_id',
							'product_option_id',
							'product_option_value_id',
							'name',
							'value',
							'type',
						];
	public $timestamps = false;
}
