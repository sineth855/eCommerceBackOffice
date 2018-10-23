<?php

namespace App\http\models\frontend\order;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $table = 'order_history';
	protected $primaryKey='order_history_id';
	protected $fillable =[
							'order_id',
							'order_status_id',
							'notify',
							'comment',
							'date_added'
						];
	public $timestamps = false;
}
