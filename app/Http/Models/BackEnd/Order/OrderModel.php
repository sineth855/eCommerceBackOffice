<?php

namespace App\Http\Models\BackEnd\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Models\BackEnd\Order\OrderShipment;

class OrderModel extends Model
{
    protected $table = 'order';
	protected $primaryKey='order_id';
	protected $fillable =[
							'invoice_no',
							'invoice_prefix',
							'store_id',
							'store_name',
							'store_url',
							'customer_id',
							'customer_group_id',
							'firstname',
							'lastname',
							'email',
							'telephone',
							'fax',
							'custom_field',
							'payment_firstname',
							'payment_lastname',
							// 'payment_email',
							// 'payment_telephone',
							'payment_company',
							'payment_address_1',
							'payment_address_2',
							'payment_city',
							'payment_postcode',
							'payment_country',
							'payment_country_id',
							'payment_zone',
							'payment_zone_id',
							'payment_address_format',
							'payment_custom_field',
							'payment_method',
							'payment_code',
							'shipping_firstname',
							'shipping_lastname',
							'shipping_company',
							// 'shipping_email',
							// 'shipping_telephone',
							'shipping_address_1',
							'shipping_address_2',
							'shipping_city',
							'shipping_postcode',
							'shipping_country',
							'shipping_country_id',
							'shipping_zone',
							'shipping_zone_id',
							'shipping_address_format',
							'shipping_custom_field',
							'shipping_method',
							'shipping_code',
							'comment',
							'total',
							'order_status_id',
							'affiliate_id',
							'commission',
							'marketing_id',
							'tracking',
							'language_id',
							'currency_id',
							'currency_code',
							'currency_value',
							'ip',
							'forwarded_ip',
							'user_agent',
							'accept_language',
							'date_added',
							'date_modified',
							];
	public $timestamps = false;
	static function filldata($data)
	{
		foreach ($fillable as $key) {
			$datas[$key]=$data[$key];
		}
		return $datas;
	}

	static function AllOrder()
	{
		$AllOrders=DB::table('order as o')
				->Join('order_status as os','o.order_status_id','=','os.order_status_id')
				->Join('shipping_courier as sc','o.shipping_courier_id','=','sc.shipping_courier_id')
				->Join('customer_group_description as cgd','o.customer_group_id','=','cgd.customer_group_id')
				->select('o.*','os.name as order_status','sc.shipping_courier_name as shipping_name','cgd.name as customer_group_name')
				->get();
		return $AllOrders;
	 }

	 static function getCarrierBaseOrder($order_id){
		 $query = DB::table('order_shipment as os')
				   ->Join('order as o', 'o.order_id', '=', 'os.order_id')
				   ->Join('carrier as c', 'c.carrier_id', '=', 'os.carrier_id')
				   ->Where('o.order_id', $order_id)
				   ->Select('os.*', 'c.name as carrier')
				   ->get();
		
		 return $query;
	 }

}
