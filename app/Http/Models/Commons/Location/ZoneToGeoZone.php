<?php

namespace App\http\models\commons\Location;

use Illuminate\Database\Eloquent\Model;

class ZoneToGeoZone extends Model
{
    protected $table = 'zone_to_geo_zone';
	protected $primaryKey='zone_to_geo_zone_id';
	protected $fillable =[
							'country_id',
							'zone_id',
							'geo_zone_id',
							'date_added',
							'date_modified',
						];
	public $timestamps = false;
}
