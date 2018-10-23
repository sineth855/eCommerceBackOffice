<?php

namespace App\Http\Models\BackEnd\Zone;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Zone extends Model
{
    protected $table='zone';
	protected $primaryKey='zone_id';
	protected $fillable=[
		'zone_id',
        'country_id',
        'name',
        'code',
        'status'
	];
	public $timestamps=false;
}
