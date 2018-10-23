<?php

namespace App\Http\Models\BackEnd\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerIp extends Model
{
    protected $table='customer_ip';
    protected $primaryKey='customer_ip_id';
    protected $fillable=[
    	'customer_id',
    	'ip',
    	'date_added'
    ];
    public $timestamps=false;
}
