<?php

namespace App\Http\Models\BackEnd\Tax\TaxRateToCustomerGroup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class TaxRateToCustomerGroup extends Model
{
    protected $table='tax_rate_to_customer_group';
    protected $primaryKey='tax_rate_id';
    protected $fillable=[
    	'tax_rate_id',
    	'customer_group_id'
    ];
    public $timestamps=false;
    static function AllTaxRateToCustomerGroup()
    {
        $taxRule=DB::table('tax_rate_to_customer_group')
                  ->leftJoin('customer_group_description','tax_rate_to_customer_group.customer_group_id','=','customer_group_description.customer_group_id')
                  ->leftJoin('tax_rate','tax_rate.tax_rate_id','=','tax_rate_to_customer_group.tax_rate_id')
                  ->leftJoin('language','language.language_id','=','customer_group_description.language_id')
                  ->select('tax_rate.tax_rate_id','customer_group_description.name as customer_group','customer_group_description.description as description','tax_rate.name as tax_rate','language.name as language')
                  ->get();
        return $taxRule;
    }
}
