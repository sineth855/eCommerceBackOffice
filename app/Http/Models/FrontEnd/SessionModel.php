<?php

namespace App\http\models\frontend;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class SessionModel extends Model
{
    protected $table = 'session';
	protected $primaryKey='session_id';
	protected $fillable = [
							'session_id',
							'data',
							'expire'
						];
	public $incrementing = false;
	public $timestamps = false;
	static function AddSession($session_id)
	{
		$data=collect(session()->all());
		$key['session_id']=$session_id;
		$value['data']=$data->toJson();
		$value['expire']=Carbon::now();
		return static::updateOrCreate($key,$value);
	}
	public function cart()
    {
    	return $this->hasManyThrough(Product::class,Cart::class,'session_id','product_id','session_id','product_id')->addSelect('product.*','cart.quantity as cart_quantity');
    }
}
