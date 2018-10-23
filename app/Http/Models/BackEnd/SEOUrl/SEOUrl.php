<?php

namespace App\Http\Models\BackEnd\SEOUrl;

use Illuminate\Database\Eloquent\Model;

class SEOUrl extends Model
{
    protected $table='seo_url';
	protected $primaryKey='store_id';
	protected $fillable=[
		'language_id',
		'store_id',
		'query',
		'keyword'
	];
	public $timestamps=false;
}
