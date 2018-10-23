<?php

namespace App\Http\Models\BackEnd\Order;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_status';
	protected $primaryKey='order_status_id';
	protected $fillable =[
							'language_id',
							'name',
						];
	public $timestamps = false;

}
