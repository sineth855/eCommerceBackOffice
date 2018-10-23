<?php

namespace App\Http\Models\BackEnd\Banner;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Banner extends Model
{
    protected $table='banner';
	protected $primaryKey='banner_id';
	protected $fillable=[
		'name',
		'status'
	];
	public $timestamps=false;

	public function BannerImage(){
		return $this->belongsTo(BannerImage::class,'banner_id');
	}
	public function Banner($id){
		return $this->hasManyThrough(Banner::class,'banner_id');
	}
	static function AllBanners($id){
		$banner=$this->Banner::with('BannerImage')->where('banner_id',$id)->get();
	}
}
