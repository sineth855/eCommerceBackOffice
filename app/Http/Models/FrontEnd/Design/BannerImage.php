<?php

namespace App\Http\Models\FrontEnd\Design;

use Illuminate\Database\Eloquent\Model;

class BannerImage extends Model
{
    protected $table = 'banner_image';
	protected $fillable = [
						'banner_image_id',
						'banner_id',
						'language_id',
						'title',
						'link',
						'image',
						'sort_order'
					];
	public $timestamps = false;
	// public function my_banners()
 //    {
 //        return $this->hasMany('App\Http\Models\FrontEnd\Design\Banner','banner_id');
 //    }
}
