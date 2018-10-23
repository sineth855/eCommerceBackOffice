<?php

namespace App\Http\Models\BackEnd\Payment;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\BackEnd\Store\Store;
use Illuminate\Support\Facades\DB;

class PaymentMethod extends Model
{
    protected $table='payment_method';
    public $timestamps = false;
    protected $primaryKey='payment_method_id';
    protected $fillable=[
    	'name',
    	'remark',
    	'status'
    ];
}
