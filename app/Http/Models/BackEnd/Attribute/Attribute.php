<?php

namespace App\Http\Models\BackEnd\Attribute;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Attribute extends Model
{
  protected $table='attribute';
  protected $primaryKey='attribute_id';
  protected $fillable=[
  	'attribute_group_id',
    'sort_order'
  ];
  public $timestamps=false;
  static function AllAttributes()
  {
      $Attribute=DB::table('attribute_description as attdesc')
                ->Join('attribute as att','att.attribute_id','=','attdesc.attribute_id')
                ->Join('attribute_group_description as attrg','att.attribute_group_id','=','attrg.attribute_group_id')
                ->Join('language','language.language_id','=','attdesc.language_id')
                ->select('att.attribute_id','att.sort_order','attdesc.name as name','attrg.name as group','language.name as language')
                ->get();
      return $Attribute;
  }
  static function AttributeEdit($id)
  {
      $Attribute=DB::table('attribute_description as attdesc')
                ->Join('attribute as att','att.attribute_id','=','attdesc.attribute_id')
                ->Join('attribute_group_description as attrg','att.attribute_group_id','=','attrg.attribute_group_id')
                ->Join('language','language.language_id','=','attdesc.language_id')
                ->select('att.attribute_id','att.attribute_group_id','attdesc.name as name','attdesc.language_id','att.sort_order')
                ->where('att.attribute_id',$id)
                ->get();
      return $Attribute;
  }
}
