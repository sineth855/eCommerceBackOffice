<?php

namespace App\http\models\frontend\Order;

use Illuminate\Database\Eloquent\Model;

class OrderShipment extends Model
{
    protected $table = 'order_shipment';
	protected $primaryKey='order_shipment_id';
	protected $fillable =[
							'order_id',
							'carrier_id',
							'tracking_number',
							'weight',
							'shipping_cost_tax_excl',
							'shipping_cost_tax_incl',
							'expected_delivery_date',
							'pickup_date',
							'pickup_time',
							'origin_pick_up',
							'destination',
							'date_added',
						];
	public $timestamps = false;

}
