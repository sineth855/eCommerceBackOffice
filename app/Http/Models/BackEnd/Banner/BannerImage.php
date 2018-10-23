<?php

namespace App\Http\Models\BackEnd\Banner;

use Illuminate\Database\Eloquent\Model;

class BannerImage extends Model
{
    protected $table='banner_image';
	protected $primaryKey='banner_id';
	protected $fillable=[
		'name',
		'status'
	];
	public $timestamps=false;
}
