<?php

namespace App\Http\Models\BackEnd\Filter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class FilterGroup extends Model
{
    protected $table='filter_group';
	protected $primaryKey='filter_group_id';
	protected $fillable=[
		'sort_order'
	];
	public $timestamps=false;
	static function AllFilterGroup()
	{
		$FilterGroups=DB::table('filter_group as filterGroup')
                ->Join('filter_group_description as desc','desc.filter_group_id','=','filterGroup.filter_group_id')
                ->Join('language','language.language_id','=','desc.language_id')
                ->select('filterGroup.filter_group_id','desc.name as name','language.name as language','filterGroup.sort_order')
                ->get();
      	return $FilterGroups;
	}
	static function FilterGroupEdit($id)
	{
		$FilterGroups=DB::table('filter_group as filterGroup')
                ->Join('filter_group_description as desc','desc.filter_group_id','=','filterGroup.filter_group_id')
                ->Join('language','language.language_id','=','desc.language_id')
                ->select('filterGroup.filter_group_id','desc.name as name','language.language_id','filterGroup.sort_order')
                ->where('filterGroup.filter_group_id',$id)
                ->get();
      	return $FilterGroups;
	}
}
