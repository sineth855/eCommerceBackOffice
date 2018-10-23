<?php

namespace App\Http\Models\BackEnd\CustomerGroup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CustomerGroup extends Model
{
    protected $table='customer_group';
    protected $primaryKey='customer_group_id';
    protected $fillable=[
    	'approval',
    	'sort_order'
    ];
    public $timestamps=false;
    static function AllCustomerGroups()
    {
    	$Groups=DB::table('customer_group as cg')
                ->Join('customer_group_description as cgdesc','cg.customer_group_id','=','cgdesc.customer_group_id')
                ->Join('language as lan','lan.language_id','=','cgdesc.language_id')
                ->select('cg.*','cgdesc.name as name','cgdesc.description as description','lan.name as language','cg.sort_order')
                ->get();
        return $Groups;
    }
    static function GroupEdit($id)
	{
		$Groups=DB::table('customer_group as cg')
                ->Join('customer_group_description as cgdesc','cg.customer_group_id','=','cgdesc.customer_group_id')
                ->Join('language as lan','lan.language_id','=','cgdesc.language_id')
                ->select('cg.customer_group_id','cgdesc.name as name','lan.language_id','cg.sort_order','approval','description')
					->where('cg.customer_group_id',$id)
					->get();
		return $Groups;
	}
}
