<?php

namespace App\Http\Models\BackEnd\Return;

use Illuminate\Database\Eloquent\Model;

class ReturnModel extends Model
{
    protected $table = 'return';
    protected $primaryKey='return_id';
    protected $fillable=[
		'order_id',
		'product_id',
		'customer_id',
		'firstname',
		'lastname',
		'email',
		'telephone',
		'product',
		'model',
		'quantity',
		'opened',
		'return_reason_id',
		'return_action_id',
		'comment',
		'date_ordered',
		'date_added',
		'date_modified',
		
    ];
    public $timestamps = false;
}
