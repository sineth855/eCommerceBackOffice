<?php

namespace App\Http\Models\FrontEnd\Account;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\FrontEnd\Account\Address;
use App\Http\Models\BackEnd\Customer\Customer;

class Address extends Model
{
    protected $table = 'address';
    protected $primarykey='address_id';
	protected $fillable = [
						'customer_id',
						'firstname',
						'lastname',
						'company',
						'address_1',
						'address_2',
						'city',
						'postcode',
						'country_id',
						'zone_id',
						'custom_field'
					];
	public $timestamps = false;	
	
	public function Customer(){
		return $this->belongsTo('App\Http\Models\FrontEnd\Customer','customer_id');
	}

	static function getAddress($sec_user_id)
	{
		$Customer = Customer::where('sec_user_id',$sec_user_id)->first();
		if($Customer){
			$Address = Address::where('customer_id',$Customer->customer_id)->get();
		}else{
			$Address = [];
		}
		return $Address;
	}
	static function getCheckoutAddress($sec_user_id)
	{
		$Customer = Customer::where('sec_user_id',$sec_user_id)->first();
		if($Customer){
			$Address = Address::where('customer_id',$Customer->customer_id)->first();
		}else{
			$Address = [];
		}
		return $Address;
	}
}