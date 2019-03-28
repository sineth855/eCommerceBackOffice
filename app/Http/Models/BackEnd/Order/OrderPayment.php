<?php

namespace App\Http\Models\BackEnd\Order;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $table = 'order_payment';
	protected $primaryKey='order_payment_id';
	protected $fillable =[
							'order_id',
							'currency_id',
							'amount',
							'payment_method',
							'conversion_rate',
							'transaction_id',
							'card_number',
							'card_brand',
							'card_expiration',
							'card_holder',
							'remark',
							'date_add',
						];
	public $timestamps = false;

}
