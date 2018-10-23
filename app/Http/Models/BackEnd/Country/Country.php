<?php

namespace App\Http\Models\BackEnd\Country;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Country extends Model
{
    protected $table='country';
	protected $primaryKey='country_id';
	protected $fillable=[
		'name',
        'iso_code_2',
        'iso_code_3',
        'address_format',
        'postcode_required',
        'status'
	];
	public $timestamps=false;
}
