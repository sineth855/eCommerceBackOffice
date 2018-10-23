<?php

namespace App\Http\Models\BackEnd\CustomerGroup\CustomerGroupDescription;

use Illuminate\Database\Eloquent\Model;

class CustomerGroupDescription extends Model
{
    protected $table='customer_group_description';
    protected $primaryKey='customer_group_id';
    protected $fillable=[
    	'customer_group_id',
    	'language_id',
    	'name',
    	'description'
    ];
    public $timestamps=false;
}
