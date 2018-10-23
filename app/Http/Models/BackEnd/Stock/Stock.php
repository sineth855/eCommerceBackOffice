<?php

namespace App\Http\Models\BackEnd\Stock;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Stock extends Model
{
    protected $table='stock_status';
    protected $primaryKey='stock_status_id';
    protected $fillable=[
    	'language_id',
    	'name'
    ];
    public $timestamps=false;
    static function AllStockStatus()
    {
        $status=DB::table('stock_status')
                  ->leftJoin('language','language.language_id','=','stock_status.language_id')
                  ->select('stock_status_id','stock_status.name as name','language.name as language')
                  ->get();
        return $status;
    }
}
