<?php

namespace App\Http\Models\BackEnd\Supplier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Supplier extends Model
{
    protected $table='supplier';
    public $timestamps=false;
    protected $primaryKey='supplier_id';
    protected $fillable=[
    	'supplier_id',
        'store_id',
        'image',
        'firstname',
        'lastname',
        'website',
        'email',
        'telephone',
        'fax',
        'address',
        'status',
        'date_added'
    ];

    static function getStoreBaseSupplierId($supplier_id)
	{
        $result = DB::table('supplier_to_store as s2s')
                    ->Join('store as s','s.store_id','s2s.store_id')
					->Where('s2s.supplier_id',$supplier_id)
                    ->OrderBy('s.name')
                    ->select('s.*')
					->get();
		return $result;
	}
}
