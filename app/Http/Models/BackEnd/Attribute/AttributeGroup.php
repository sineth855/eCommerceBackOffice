<?php

namespace App\Http\Models\BackEnd\Attribute;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class AttributeGroup extends Model
{
    protected $table='attribute_group';
  	protected $primaryKey='attribute_group_id';
	protected $fillable=[
	  	'sort_order'
	];
	public $timestamps=false;
	static function AllAttributesGroup()
  {
      $AttributeGroup=DB::table('attribute_group_description as attdesc')
                ->Join('attribute_group as att','att.attribute_group_id','=','attdesc.attribute_group_id')
                ->Join('language','language.language_id','=','attdesc.language_id')
                ->select('att.attribute_group_id','attdesc.name as name','language.name as language','att.sort_order')
                ->get();
      return $AttributeGroup;
  }
  static function AttributeGroupEdit($id)
  {
      $AttributeGroup=DB::table('attribute_group_description as attdesc')
                ->Join('attribute_group as att','att.attribute_group_id','=','attdesc.attribute_group_id')
                ->Join('language','language.language_id','=','attdesc.language_id')
                ->select('att.attribute_group_id','attdesc.name as name','language.language_id','att.sort_order')
                ->where('att.attribute_group_id',$id)
                ->get();
      return $AttributeGroup;
  }
}
