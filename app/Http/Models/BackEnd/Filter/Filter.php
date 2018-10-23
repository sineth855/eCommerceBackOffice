<?php

namespace App\Http\Models\BackEnd\Filter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Filter extends Model
{
  protected $table='filter';
  protected $primaryKey='filter_id';
  protected $fillable=[
  	'filter_group_id',
    'sort_order'
  ];
  public $timestamps=false;
  static function getFiltersBaseProductId($product_id)
  {
      $Filters=DB::table('product_filter as pf')
                ->Join('filter_description as desc','pf.filter_id','=','desc.filter_id')
                ->Join('filter as filter','filter.filter_id','=','desc.filter_id')
                ->Join('filter_group_description as filterGroup','filter.filter_group_id','=','filterGroup.filter_group_id')
                ->Join('language','language.language_id','=','desc.language_id')
                ->where('pf.product_id', $product_id)
                ->select('filter.filter_id','desc.name as name','filterGroup.name as group','language.name as language','filter.sort_order')
                ->get();
      return $Filters;
  }

  static function AllFilters()
  {
      $Filters=DB::table('filter_description as desc')
                ->Join('filter as filter','filter.filter_id','=','desc.filter_id')
                ->Join('filter_group_description as filterGroup','filter.filter_group_id','=','filterGroup.filter_group_id')
                ->Join('language','language.language_id','=','desc.language_id')
                ->select('filter.filter_id','desc.name as name','filterGroup.name as group','language.name as language','filter.sort_order')
                ->get();
      return $Filters;
  }
  static function FilterEdit($id)
  {
      $Filters=DB::table('filter_description as desc')
                ->Join('filter as filter','filter.filter_id','=','desc.filter_id')
                ->Join('filter_group_description as filterGroup','filter.filter_group_id','=','filterGroup.filter_group_id')
                ->Join('language','language.language_id','=','desc.language_id')
                ->select('filter.filter_id','desc.name as name','filterGroup.filter_group_id','language.language_id','filter.sort_order')
                ->where('filter.filter_id',$id)
                ->get();
      return $Filters;
  }
}
