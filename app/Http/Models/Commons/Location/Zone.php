<?php

namespace App\http\models\commons\Location;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zone';
	protected $primaryKey='zone_id';
	protected $fillable =[
							'country_id',
							'name',
							'code',
							'status',
						];
	public $timestamps = false;
}
