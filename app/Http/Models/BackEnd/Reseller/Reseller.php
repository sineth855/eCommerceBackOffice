<?php

namespace App\Http\Models\BackEnd\Reseller;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Reseller extends Model
{
    protected $table='reseller';
    public $timestamps=false;
    protected $primaryKey='reseller_id';
    protected $fillable=[
    	'store_id',
        'sec_user_id',
        'firstname',
        'lastname',
        'store_name',
        'gender',
        'dob',
        'company',
        'website',
        'owner',
        'address_1',
        'address_2',
        'email',
        'email_2',
        'telephone_1',
        'telephone_2',
        'country',
        'province',
        'fax',
        'city',
        'code',
        'image',
        'status',
        'date_added',
        'updated_at'
    ];
}
