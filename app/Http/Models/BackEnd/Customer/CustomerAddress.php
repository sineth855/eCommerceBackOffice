<?php

namespace App\Http\Models\BackEnd\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $table='address';
    protected $primaryKey='customer_id';
    protected $fillable=[
    	'customer_id',
    	'firstname',
    	'lastname',
    	'company',
    	'address_1',
    	'address_2',
    	'city',
    	'postcode',
        'country',
        'zone'
    ];
    public $timestamps=false;
}
