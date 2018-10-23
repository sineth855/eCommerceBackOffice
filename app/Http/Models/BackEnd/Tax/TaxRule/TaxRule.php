<?php

namespace App\Http\Models\BackEnd\Tax\TaxRule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class TaxRule extends Model
{
    protected $table='tax_rule';
    protected $primaryKey='tax_rule_id';
    protected $fillable=[
    	'tax_rate_id',
    	'tax_class_id',
    	'based',
    	'priority'
    ];
    public $timestamps=false;
    static function AllTaxRule()
    {
        $taxRule=DB::table('tax_rule')
                  ->leftJoin('tax_class','tax_class.tax_class_id','=','tax_rule.tax_class_id')
                  ->leftJoin('tax_rate','tax_rate.tax_rate_id','=','tax_rule.tax_rate_id')
                  ->select('tax_rule_id','tax_class.title as tax_class','tax_rate.name as tax_rate','based','priority')
                  ->get();
        return $taxRule;
    }
}
