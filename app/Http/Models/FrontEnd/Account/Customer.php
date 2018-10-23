<?php

namespace App\Http\Models\FrontEnd\Account;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primarykey='customer_id';
	protected $fillable = [
						'customer_id',
						'sec_user_id',
						'customer_group_id',
						'store_id',
						'language_id',
						'firstname',
						'lastname',
						'email',
						'telephone',
						'fax',
						'password',
						'salt',
						'cart',
						'wishlist',
						'newsletter',
						'address_id',
						'custom_field',
						'ip',
						'status',
						'safe',
						'token',
						'code',
						'date_added'
					];

	public function address(){
		return $this->belongsTo(Address::class,'address_id');
		// return $this->hasMany(Address::class)->addSelect('*');
		// return $this->belongsTo('App\Http\Models\FrontEnd\Account\Address','address_id');
	}

	public $timestamps = false;	
}
