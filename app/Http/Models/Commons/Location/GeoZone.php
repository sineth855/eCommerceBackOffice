<?php

namespace App\http\models\commons\Location;

use Illuminate\Database\Eloquent\Model;

class GeoZone extends Model
{
    protected $table = 'geo_zone';
	protected $primaryKey='geo_zone_id';
	protected $fillable =[
							'name',
							'description',
							'date_added',
							'date_modified',
						];
	public $timestamps = false;
}
