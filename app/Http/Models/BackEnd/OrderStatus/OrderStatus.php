<?php

namespace App\Http\Models\BackEnd\OrderStatus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class OrderStatus extends Model
{
    protected $table='order_status';
    protected $primaryKey='order_status_id';
    protected $fillable=[
    	'language_id',
    	'name'
    ];
    public $timestamps=false;
    static function AllStockStatus()
    {
        $status=DB::table('order_status')
                  ->leftJoin('language','language.language_id','=','order_status.language_id')
                  ->select('order_status_id','order_status.name as name','language.name as language')
                  ->get();
        return $status;
    }
}
