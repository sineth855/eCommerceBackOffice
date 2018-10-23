<?php

namespace App\Http\Models\BackEnd\CreditOption;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CreditTypeValue extends Model
{
    protected $table='credit_type_value';
    protected $primaryKey='credit_type_value_id';
    protected $fillable=[
    	'credit_type_id',
    	'name',
    	'value'
    ];
    public $timestamps=false;
    static function AllCreditTypeValue()
    {
        $creditType=DB::table('credit_type_value')
                  ->leftJoin('credit_type','credit_type.credit_type_id','=','credit_type_value.credit_type_id')
                  ->select('credit_type_value_id','credit_type.name as type','credit_type_value.name as name','credit_type_value.value as value')
                  ->get();
        return $creditType;
    }
}
