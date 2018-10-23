<?php

namespace App\http\models\frontend\Order;

use Illuminate\Database\Eloquent\Model;

class OrderTotal extends Model
{
    protected $table = 'order_total';
	protected $primaryKey='order_total_id';
	protected $fillable =[
							'order_id',
							'code',
							'title',
							'value',
							'sort_order',
						];
	public $timestamps = false;

}
