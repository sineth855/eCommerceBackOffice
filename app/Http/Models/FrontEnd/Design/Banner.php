<?php

namespace App\Http\Models\FrontEnd\Design;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banner';
	protected $fillable = [
						'banner_id',
						'name',
						'status'
					];
	public $timestamps = false;

	public function banner_images(){
		return $this->belongsTo('App\Http\Models\FrontEnd\Design\BannerImage','banner_id');
	}

}
