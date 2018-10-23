<?php

namespace App\Http\Models\BackEnd\Information;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Information extends Model
{
    protected $table='information';
  protected $primaryKey='information_id';
  protected $fillable=[
  	'bottom',
    'sort_order',
    'status'
  ];
  public $timestamps=false;
  static function AllInformations()
  {
      $Filters=DB::table('information as inf')
                ->Join('information_description as desc','inf.information_id','=','desc.information_id')
                ->Join('information_to_store as store','store.information_id','=','inf.information_id')
                // ->leftJoin('information_to_layout as inflayout','inflayout.information_id','=','inf.information_id')
                // ->Join('information_to_store as store','store.information_id','=','inf.information_id')
                // ->Join('language','language.language_id','=','desc.language_id')
                ->where('store.store_id', config_store_id)
                ->where('desc.language_id', config_language_id)
                ->select(
                	'inf.information_id',
                	'desc.title',
                	// 'language.name as language',
                	'inf.sort_order',
                	'inf.bottom',
                	'inf.status',
                	'desc.description',
                	'desc.meta_title',
                	'desc.meta_description',
                	'desc.meta_keyword')
                ->get();
      return $Filters;
  }
  static function InformationEdit($id)
  {
      $Filters=DB::table('information as inf')
                ->Join('information_description as desc','inf.information_id','=','desc.information_id')
                ->leftJoin('information_to_layout as inflayout','inflayout.information_id','=','inf.information_id')
                ->Join('information_to_store as store','store.information_id','=','inf.information_id')
                ->Join('language','language.language_id','=','desc.language_id')
                ->select(
                	'inf.information_id',
                	'desc.title',
                	'language.language_id',
                	'inf.sort_order',
                	'inf.bottom',
                	'inf.status',
                	'store.store_id',
                	'inflayout.layout_id',
                	'desc.description',
                	'desc.meta_title',
                	'desc.meta_description',
                	'desc.meta_keyword')
                ->where('inf.information_id',$id)
                ->get();
      return $Filters;
  }
}
