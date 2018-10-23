<?php

namespace App\Http\Models\BackEnd\CreditOption;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Models\BackEnd\CreditOption\CreditTypeValue;
class CreditType extends Model
{
    protected $table='credit_type';
    protected $primaryKey='credit_type_id';
    protected $fillable=[
    	'language_id',
    	'name'
    ];
    public $timestamps=false;
    static function AllCreditType()
    {
        $creditType=DB::table('credit_type as crt')
                  ->leftJoin('language as ln','ln.language_id','=','crt.language_id')
                  ->leftJoin('credit_type_value as crtv','crt.credit_type_id','=','crtv.credit_type_id')
                  ->select('crt.credit_type_id','crt.name as name','crtv.name as type','crtv.value as value','ln.name as language')
                  ->get();
        return $creditType;
    }
    public function CreditTypeValue(){
        return $this->hasOne(CreditTypeValue::class,'credit_type_id');
    }
    static function CreditTypeEdit($id){

        $dataValue = CreditType::find($id)->CreditTypeValue;
        $dataType = CreditType::find($id);
        return [$dataValue,$dataType];
        
    }
}
